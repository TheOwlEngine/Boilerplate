<?php

namespace App\Console\Commands;

use App\Models\Post;
use DOMDocument;
use Illuminate\Console\Command;

class SitemapGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routes = [
            '/' => [
                'en' => '/',
                'id' => '/',
                'priority' => 1,
            ],
        ];

        $posts = Post::select('id', 'blog_category_id', 'slug')->where('published_at', '<=', now())->get();

        $postBracket = [];

        foreach ($posts as $post) {

            foreach ($post->getTranslations('slug') as $language => $slug) {
                $postBracketSlug = [
                    'model' => 'post',
                    'entity' => $post->id,  
                ];
                
                if (in_array($slug, [ 'articles', 'artikel', 'about', 'tentang' ])) {
                    $slug = '/' . $slug;
                    $postBracketSlug['priority'] = 1.0;
                } else {
                    if ($language == 'en') {
                        $slug = '/articles/' . $slug;
                    } else {
                        $slug = '/artikel/' . $slug;
                    }

                    $postBracketSlug['priority'] = 0.80;
                }

                $postBracketSlug['language'] = $language;

                $postBracket[$slug] = $postBracketSlug;
            }

        }

        $sortedRoutes = array_merge($routes, $postBracket);

        ksort($sortedRoutes);

        file_put_contents(public_path('redirection.json'), json_encode($sortedRoutes));

        $createdSitemap = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

        foreach ($sortedRoutes as $slug => $value) {
            $createdSitemap .= '<url><loc>' . str_replace(':/','://', trim(preg_replace('/\/+/', '/', config('app.url') . $slug), '/')) . '</loc><lastmod>' . date("Y-m-d\TH:i:s+00:00") . '</lastmod><changefreq>daily</changefreq><priority>' . $value['priority'] . '</priority></url>';
        }

        $createdSitemap .= '</urlset>';

        $dom = new DOMDocument();

        $dom->preserveWhiteSpace = false;
        $dom->loadXML($createdSitemap, LIBXML_HTML_NOIMPLIED);
        $dom->formatOutput = true;

        file_put_contents(public_path('sitemap.xml'), $dom->saveXML($dom->documentElement));

        return 0;
    }
}
