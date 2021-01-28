<?php

namespace App\Components\Extension;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait FileExtension
{
    /**
     * Create a file in given disk.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @param string $directory
     * @param string $name
     * @return void
     */
    protected function uploadFile(UploadedFile $file, $disk, $directory, $name = null)
    {
        $name ? self::FileSystemInstance($disk)->putFileAs($directory, $file, $name) : self::FileSystemInstance($disk)->putFile($directory, $file);
    }

    /**
     * Write the given content into the file.
     *
     * @param string $disk
     * @param string $directory
     * @param string $name
     * @param string $content
     * @return void
     */
    protected function writeFile($disk, $directory, $name, $content)
    {
        self::FileSystemInstance($disk)->put((self::normalizePath($directory) . $name), $content);
    }

    /**
     * Get the content of given file.
     *
     * @param string $disk
     * @param string $directory
     * @param string $name
     * @return string
     *
     * @throws FileNotFoundException
     */
    protected function readFile($disk, $directory, $name)
    {
        return self::FileSystemInstance($disk)->get(self::normalizePath($directory) . $name);
    }

    /**
     * Edit the given file with the specified content.
     *
     * @param string $disk
     * @param string $directory
     * @param string $name
     * @param string $content
     * @return void
     */
    protected function editFile($disk, $directory, $name, $content)
    {
        self::FileSystemInstance($disk)->update((self::normalizePath($directory) . $name), $content);
    }

    /**
     * Delete the given file in given disk.
     *
     * @param string $disk
     * @param string $directory
     * @param string $name
     * @return void
     *
     * @throws ValidationException
     */
    public static function deleteFile($disk, $directory, $name)
    {
        $filesystem = self::FileSystemInstance($disk);

        $path = self::normalizePath($directory) . $name;

        if ($filesystem->exists($path)) {
            $filesystem->delete($path);
            return;
        }

        throw new ValidationException(null, self::errorResponse());
    }

    /**
     * Return all files in given disk and directory.
     *
     * @param string $disk
     * @param string $directory
     * @return array
     */
    protected function getAllFiles($disk, $directory)
    {
        return array_map(function ($file) use ($directory) {
            return Str::replaceArray(($directory . '/'), [''], $file);
        }, self::FileSystemInstance($disk)->allFiles($directory));
    }

    /**
     * Return file last modified time.
     *
     * @param string $disk
     * @param string $directory
     * @param string $name
     * @return int
     */
    public function getFileLastModified($disk, $directory, $name)
    {
        return self::FileSystemInstance($disk)->lastModified(self::normalizePath($directory) . $name);
    }

    /**
     * Create Filesystem instance.
     *
     * @param string $disk
     * @return Filesystem
     */
    private static function FileSystemInstance($disk)
    {
        return Storage::disk($disk);
    }

    /**
     * Normalize the given path.
     *
     * @param string $path
     * @return string
     */
    private static function normalizePath(&$path)
    {
        if (!Str::startsWith($path, '/')) {
            $path = '/' . $path;
        }
        if (!Str::endsWith($path, '/')) {
            $path = $path . '/';
        }

        return $path;
    }

    /**
     * Return the error response.
     *
     * @return JsonResponse
     */
    private static function errorResponse()
    {
        return response()->json(['message' => 'Unable to delete the file.', 'status' => 422], 422);
    }
}
