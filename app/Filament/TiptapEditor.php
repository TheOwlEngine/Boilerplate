<?php

namespace App\Filament;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Filament\Forms\Components\Concerns\CanBeLengthConstrained;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Contracts\CanBeLengthConstrained as CanBeLengthConstrainedContract;
use Livewire\TemporaryUploadedFile;

class TiptapEditor extends Field implements CanBeLengthConstrainedContract
{
    use CanBeLengthConstrained;
    use HasExtraInputAttributes;
    use HasExtraAlpineAttributes;

    protected string $view = 'filament-tiptap-editor::tiptap-editor';

    protected ?Closure $saveUploadedFileUsing = null;

    public string $profile = 'default';

    protected ?array $tools = [];

    protected ?string $disk = null;

    protected string | Closure | null $directory = null;

    protected ?array $acceptedFileTypes = null;

    protected ?int $maxFileSize = 2042;

    protected function setUp(): void
    {
        parent::setUp();

        $this->profile = implode(',', config('filament-tiptap-editor.profiles.default'));
    }

    public function profile(?string $profile)
    {
        $this->profile = implode(',', config('filament-tiptap-editor.profiles.' . $profile));

        return $this;
    }

    public function toolbarButtons(array $tools): static
    {
        $this->tools = $tools;

        return $this;
    }

    public function saveUploadedFileUsing(?Closure $callback): static
    {
        $this->saveUploadedFileUsing = $callback;

        return $this;
    }

    public function saveUploadedFiles(): void
    {
        if (blank($this->getState())) {
            $this->state([]);

            return;
        }

        if (!is_array($this->getState())) {
            $this->state([$this->getState()]);
        }

        $state = array_map(function (TemporaryUploadedFile | string $file) {
            if (!$file instanceof TemporaryUploadedFile) {
                return $file;
            }

            $callback = $this->saveUploadedFileUsing;

            if (!$callback) {
                $file->delete();

                return $file;
            }

            $storedFile = $this->evaluate($callback, [
                'file' => $file,
            ]);

            $file->delete();

            return $storedFile;
        }, $this->getState());

        if ($this->canReorder && ($callback = $this->reorderUploadedFilesUsing)) {
            $state = $this->evaluate($callback, [
                'state' => $state,
            ]);
        }

        $this->state($state);
    }

    public function tools(array $tools): static
    {
        $this->tools = $tools;

        return $this;
    }

    public function disk(?string $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function directory(string | Closure | null $directory): static
    {
        $this->directory = $directory;

        return $this;
    }

    public function acceptedFileTypes(?array $acceptedFileTypes): static
    {
        $this->acceptedFileTypes = $acceptedFileTypes;

        return $this;
    }

    public function maxFileSize(?int $maxFileSize): static
    {
        $this->maxFileSize = $maxFileSize;

        return $this;
    }

    public function getTools(): string
    {
        return !$this->tools ? $this->profile : implode(',', $this->tools);
    }

    public function getDisk(): string
    {
        return $this->disk ?? config('filament-tiptap-editor.disk');
    }

    public function getDirectory(): string
    {
        return $this->directory ? $this->evaluate($this->directory) : config('filament-tiptap-editor.directory');
    }

    public function getAcceptedFileTypes(): array
    {
        return $this->acceptedFileTypes ?? config('filament-tiptap-editor.accepted_file_types');
    }

    public function getMaxFileSize(): int
    {
        return $this->maxFileSize ?? config('filament-tiptap-editor.max_file_size');
    }
}
