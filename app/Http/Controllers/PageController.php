<?php

namespace App\Http\Controllers;

use App;
use App\Filament\Settings\SitesSettings;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;
use App\Models\Post;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Session;
use Str;

class PageController extends Controller
{
    protected $menu = null;
    protected $page = null;

    protected function setting($key)
    {
        return app(SitesSettings::class)->{$key};
    }

    public function __construct()
    {
        /**
         * Language
         */
        if (config('app.env') == 'production') {
            if (in_array(request()->getPathInfo(), ['', '/', '/switch/en', '/switch/id'])) {
                $currentLanguage = request()->session()->get('locale') ?? 'en';
            } else {
                $currentLanguage = request()->session()->get('locale');
            }
        } else {
            $currentLanguage = request()->session()->get('locale') ?? 'en';
        }

        if (!Cache::get('redirection')) {
            $redirection = json_decode(file_get_contents(public_path('redirection.json')));

            Cache::put('redirection', $redirection, Carbon::now()->endOfDay());
        } else {
            $redirection = Cache::get('redirection');
        }

        $detectedRoute = null;

        if (isset($redirection->{request()->getPathInfo()})) {
            $detectedRoute = $redirection->{request()->getPathInfo()};

            if (isset($detectedRoute->language)) {
                if (!$currentLanguage) {
                    $currentLanguage = $detectedRoute->language;
                }

                if ($currentLanguage && ($currentLanguage !== $detectedRoute->language)) {
                    $currentLanguage = $detectedRoute->language;
                }
            }
        }

        App::setLocale($currentLanguage);

        /**
         * Navigation
         */
        $this->menu = FilamentNavigation::get('menu_' . $currentLanguage);

        /**
         * Aliases
         */
        $aliases = [
            'en' => [
                'article' => 'articles',
                'about'   => 'about',
                'locale'  => 'en-US',
            ],
            'id' => [
                'article' => 'artikel',
                'about'   => 'tentang',
                'locale'  => 'id-ID',
            ],
        ];
        $currentAlias = $aliases[$currentLanguage];

        /**
         * Page & SEO
         */
        $this->page = (object) [
            'banner' => $this->setting('site_profile'),
            'excerpt' => $this->setting('site_description_' . $currentLanguage),
            'title' => $currentLanguage == 'en' ? 'Home' : 'Beranda',
            'tags' => explode(',', $this->setting('site_keywords_' . $currentLanguage)),
        ];

        if (isset($detectedRoute->model)) {
            $page = Post::find($detectedRoute->entity);

            if ($page) {
                $this->page->title = $page->getTranslation('title', $currentLanguage);
                $this->page->excerpt = $page->getTranslation('excerpt', $currentLanguage);
                $this->page->content = $page->getTranslation('content', $currentLanguage);
                $this->page->banner = $page->getTranslation('banner', $currentLanguage);
                $this->page->tags = $page->tags;
            }
        }

        SEOMeta::setTitleDefault($this->setting('site_name_' . $currentLanguage));
        SEOMeta::setTitleSeparator(' | ');
        SEOMeta::setTitle($this->page->title);
        SEOMeta::setDescription($this->page->excerpt ?? $this->setting('site_description_' . $currentLanguage));

        $keywords = [];

        foreach ($this->page->tags as $tag) {
            $keywords[] = trim($tag->name ?? $tag);
        }

        SEOMeta::addKeyword($keywords);

        OpenGraph::setDescription($this->page->excerpt);
        OpenGraph::setTitle($this->page->title . ' | ' . $this->setting('site_name_' . $currentLanguage));
        OpenGraph::setSiteName($this->setting('site_name_' . $currentLanguage));
        OpenGraph::setUrl(request()->url());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', $currentAlias['locale']);
        OpenGraph::addImage(config('app.url') . 'storage/' . ($this->page->banner));

        TwitterCard::setType('website');
        TwitterCard::setTitle($this->page->title . ' | ' . $this->setting('site_name_' . $currentLanguage));
        TwitterCard::setSite($this->setting('site_name_' . $currentLanguage));
        TwitterCard::setDescription($this->page->excerpt);
        TwitterCard::setUrl(request()->url());
        TwitterCard::setImage(config('app.url') . 'storage/' . ($this->page->banner));

        JsonLd::setType('website');
        JsonLd::setTitle($this->page->title . ' | ' . $this->setting('site_name_' . $currentLanguage));
        JsonLd::setSite($this->setting('site_name_' . $currentLanguage));
        JsonLd::setDescription($this->page->excerpt);
        JsonLd::setUrl(request()->url());
        JsonLd::setImage(config('app.url') . 'storage/' . ($this->page->banner));
    }

    /**
     * home
     */
    public function home(Request $request)
    {
        return view('pages.home', [
            'page' => $this->page,
            'menu' => $this->menu,
        ]);
    }

    /**
     * article
     */
    public function article(Request $request)
    {
        try {
            $articles = Post::whereNot('blog_category_id', 1)->where('published_at', '<=', now())->whereNot('id', 4)->orderBy('published_at', 'DESC')->get();

            return view('pages.article', [
                'page' => $this->page,
                'menu' => $this->menu,
                'articles' => $articles,
            ]);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    /**
     * article detail
     */
    public function articleDetail(Request $request, $slug)
    {
        try {
            $previousLanguage = Session::get('locale');
            $redirection = Cache::get('redirection');

            if (isset($redirection->{$request->getPathInfo()})) {
                $detectedRoute = $redirection->{$request->getPathInfo()};
                $previousLanguage = $detectedRoute->language;
            }

            App::setlocale($previousLanguage);

            $article = Post::where("slug->" . app()->getLocale() . " = '" . $slug . "'")->firstOrFail();

            function generatorCode($text)
            {
                return preg_replace_callback('/<pre\s(.*?)><code\s(.*?)>\[(.*):(.*)\]\n([\s\S]*?)<\/code><\/pre>/m', function ($matches) {
                    $source_code = '';
                    $pattern_links = '/\[(.*)\]\((.*)\)/m';

                    preg_match_all($pattern_links, $matches[5], $links);

                    if (count($links[0]) > 0) {
                        $source_code = '<div class="flex items-center justify-center py-2 bg-gray-50 border-t">';

                        foreach ($links[2] as $index => $link) {
                            $source_code .= '<a href="' . $link . '" target="_blank" rel="noopener" class="bg-white hover:bg-gray-50 flex gap-2 items-center py-2 px-4 text-md text-gray-500 text-sm no-underline rounded-lg border border-gray-200">';
                            $source_code .= '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>';
                            $source_code .= $links[1][$index];
                            $source_code .= '</a>';
                        }

                        $source_code .= '</div>';
                        $matches[5] = preg_replace($pattern_links, '', $matches[5]);
                    }

                    return <<<EOD
                        <div class="border rounded-lg bg-white overflow-hidden">
                            <div class="flex items-center justify-between bg-gray-50 border-b">
                                <div class="flex gap-2 px-4">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="py-2 px-4 text-gray-500">$matches[4]</div>
                                <div class="py-2 px-4 uppercase text-xs font-medium text-gray-500">$matches[3]</div>
                            </div>
                            <div style="padding: 4px 10px;">
                                <pre><code $matches[2]>$matches[5]</code></pre>
                            </div>
                            $source_code
                        </div>
                    EOD;
                }, $text);
            }

            function generatorImage($text)
            {
                return preg_replace_callback('/<img(.*?)title="(.*?)"(.*?)>/m', function ($matches) {
                    return <<<EOD
                        <div class="text-center">
                            <div class="rounded-lg bg-white overflow-hidden">
                                $matches[0]
                            </div>
                            <div class="mt-2 text-gray-500 italic text-sm">
                                $matches[2]
                            </div>
                        </div>
                    EOD;
                }, $text);
            }

            function generatorToC($text)
            {
                $htmlFinder = '/<h([2-3])>([\s\S]*?)<\/h([2-3])>/m';
                $syntaxTree = [];
                $titleIndex = -1;
                $tableTitle = app()->getLocale() == 'en' ? 'Table of Contents' : 'Daftar Isi';

                preg_match_all($htmlFinder, $text, $matches);

                foreach ($matches[0] as $index => $value) {
                    $titleText = trim(preg_replace($htmlFinder, '$2', $value));

                    if (strpos($value, '<h2>') !== false) {
                        $titleIndex = $index;
                        $syntaxTree[$index] = [
                            'title' => $titleText,
                            'slug' => Str::slug($titleText),
                            'children' => [],
                        ];
                    }

                    if (strpos($value, '<h3>') !== false) {
                        $syntaxTree[$titleIndex]['children'][] = [
                            'title' => $titleText,
                            'slug' => Str::slug($titleText),
                            'children' => [],
                        ];
                    }
                }

                $text = preg_replace_callback($htmlFinder, function ($matches) {
                    return '<h' . $matches[1] . ' id="' . Str::slug($matches[2]) . '">' . $matches[2] . '</h' . $matches[3] . '>';
                }, $text);

                $tableTree = '<h2 id="' . Str::slug($tableTitle) . '">' . $tableTitle . '</h2>';
                $tableTree .= '<ol>';

                foreach ($syntaxTree as $item) {
                    $tableTree .= '<li>';
                    $tableTree .= '    <a class="font-normal no-underline hover:underline" href="#' . $item['slug'] . '">' . $item['title'] . '</a>';
                    $tableTree .= '</li>';

                    if (count($item['children']) > 0) {
                        $tableTree .= '<ol type="i">';

                        foreach ($item['children'] as $subItem) {
                            $tableTree .= '<li>';
                            $tableTree .= '   <a class="font-normal no-underline hover:underline" href="#' . $subItem['slug'] . '">' . $subItem['title'] . '</a>';
                            $tableTree .= '</li>';

                            if (count($subItem['children']) > 0) {
                                $tableTree .= '<ul type="disk">';

                                foreach ($subItem['children'] as $underSubItem) {
                                    $tableTree .= '<li>';
                                    $tableTree .= '   <a class="font-normal no-underline hover:underline" href="#' . $underSubItem['slug'] . '">' . $underSubItem['title'] . '</a>';
                                    $tableTree .= '</li>';
                                }

                                $tableTree .= '</ul>';
                            }
                        }

                        $tableTree .= '</ol>';
                    }
                }

                $tableTree .= '</ol>';

                $text = $tableTree . $text;

                return $text;
            }

            $article->content = generatorCode($article->content);
            $article->content = generatorImage($article->content);
            $article->content = preg_replace('/language-json/m', 'language-javascript', $article->content);
            $article->content = generatorToC($article->content);

            return view('pages.article-detail', [
                'page' => $this->page,
                'menu' => $this->menu,
                'article' => $article,
            ]);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    /**
     * about
     */
    public function about(Request $request)
    {
        $slug = app()->getLocale() == 'en' ? 'about' : 'tentang';
        $article = Post::where("slug->" . app()->getLocale() . "", $slug)->firstOrFail();
        try {

            return view('pages.article-detail', [
                'page' => $this->page,
                'menu' => $this->menu,
                'article' => $article,
            ]);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    /**
     * switch
     */
    public function switch(Request $request, $nextLanguage)
    {
        $previousRoute = str_replace(config('app.url'), '', $request->headers->get('referer'));
        $previousLanguage = Session::get('locale');

        $redirection = Cache::get('redirection');

        if (isset($redirection->{'/' . $previousRoute})) {
            $detectedRoute = $redirection->{'/' . $previousRoute};

            if (isset($detectedRoute->language)) {
                if (!$previousLanguage) {
                    $previousLanguage = $detectedRoute->language;
                }

                if ($previousLanguage && ($previousLanguage !== $detectedRoute->language)) {
                    $previousLanguage = $detectedRoute->language;
                }
            }
        }

        $nextRoute = '';

        $singleRoute = [
            'articles' => 'artikel',
            'artikel'  => 'articles',
            'about'    => 'tentang',
            'tentang'  => 'about',
        ];

        if (!in_array($previousRoute, ['', '/'])) {
            if (in_array($previousRoute, array_keys($singleRoute))) {
                $nextRoute = $singleRoute[$previousRoute];
            } else {
                $splitedRoute = explode('/', $previousRoute);

                if (count($splitedRoute) > 1 && !empty($splitedRoute[1])) {

                    switch ($splitedRoute[0]) {
                        case 'articles':
                        case 'artikel':
                            $detectedEntity = Post::where("slug->" . $previousLanguage . "", $splitedRoute[1])->first();

                            if ($detectedEntity) {
                                $detectedSlug = $detectedEntity->getTranslation('slug', $nextLanguage);

                                $nextSection = $singleRoute[$splitedRoute[0]];
                                $nextRoute = $nextSection . '/' . str_replace($nextSection . '-', '', $detectedSlug);
                            }
                            break;
                    }
                } else {
                    $nextRoute = $singleRoute[$splitedRoute[0]];
                }
            }
        }

        Session::put('locale', $nextLanguage);

        return redirect()->to(config('app.url') . $nextRoute);
    }

    /**
     * subscribe
     */
    public function subscribe(Request $request)
    {
        if ($request->email) {
            Newsletter::create([
                'ip' => $request->ip(),
                'email' => $request->email,
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('home');
        } else {
            return abort(403);
        }
    }
}
