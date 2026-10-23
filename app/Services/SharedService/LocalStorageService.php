<?php

namespace App\Services\SharedService;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalStorageService
{
    protected string $disk;
    protected ?string $namePrefix = null;
    protected bool $keepOriginalName = false;

    public function __construct(string $disk = 'public')
    {
        $this->disk = $disk;
    }

    /**
     * Set a prefix for the generated filenames.
     *
     * @param string|null $prefix
     * @return static
     */
    public function setNamePrefix(?string $prefix): static
    {
        $this->namePrefix = $prefix;
        return $this;
    }

    /**
     * Determine whether to keep the original filename (slugified).
     *
     * @param bool $keep
     * @return static
     */
    public function keepOriginalName(bool $keep = true): static
    {
        $this->keepOriginalName = $keep;
        return $this;
    }

    /**
     * Store an uploaded file in a specified directory with configurable naming.
     *
     * @param UploadedFile $file
     * @param string $directory Path/folder where the file will be stored
     * @param string|null $customFilename Explicit custom filename
     * @return string Returns the stored file path
     */
    public function upload(UploadedFile $file, string $directory, ?string $customFilename = null): string
    {
        if ($customFilename) {
            $filename = $customFilename;
        } else {
            $extension = $file->getClientOriginalExtension();
            if ($this->keepOriginalName) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $baseName = Str::slug($originalName) . '-' . time();
            } else {
                $baseName = Str::uuid();
            }

            $prefix = $this->namePrefix ? trim($this->namePrefix, '_-') . '_' : '';
            $filename = $prefix . $baseName . '.' . $extension;
        }

        return $file->storeAs($directory, $filename, $this->disk);
    }

    /**
     * Store raw file contents in a specified directory.
     *
     * @param string $contents
     * @param string $directory
     * @param string $filename
     * @return string
     */
    public function put(string $contents, string $directory, string $filename): string
    {
        $path = trim($directory, '/') . '/' . ltrim($filename, '/');
        Storage::disk($this->disk)->put($path, $contents);

        return $path;
    }

    /**
     * Delete a file from storage.
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }

    /**
     * Get the full URL or path of a stored file.
     *
     * @param string $path
     * @return string
     */
    public function url(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Check if a file exists.
     *
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }
}
