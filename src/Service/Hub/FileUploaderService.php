<?php

namespace App\Service\Hub;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

readonly class FileUploaderService
{
    public function __construct(private Filesystem $filesystem, private string $uploadsDirectory)
    {
    }

    public function upload(UploadedFile $file, ?string $filename): string
    {
        $originalFilename = $filename ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalFilename . '.' . $file->guessExtension();
        $file->move($this->uploadsDirectory . '/album', $fileName);

        return $fileName;
    }

    public function download(string $url, string $filename): string
    {
        $client = new Client();
        try {
            $response = $client->get($url);
            $content = $response->getBody()->getContents();
            $filename = $filename . '.' . pathinfo($url, PATHINFO_EXTENSION);
            $filePath = $this->uploadsDirectory . '/album/' . $filename;;
            file_put_contents($filePath, $content);

        } catch(FileException|GuzzleException $e) {
            dd($e);
        }

        return $filename;
    }

    public function remove(string $filename): void
    {
        if($this->filesystem->exists($this->uploadsDirectory . '/' . $filename)) {
            $this->filesystem->remove($this->uploadsDirectory . '/' . $filename);
        }
    }
}
