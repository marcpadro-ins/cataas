<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Models\CatImage;

class CatImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $response = $client->get('https://cataas.com/api/cats?&skip=0&limit=100000');
        $data = json_decode($response->getBody(), true);

        // Crear carpeta si no existeix
        $directory = storage_path('app/public/cat_images');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        foreach ($data as $item) {
            $imageUrl = "https://cataas.com/cat/{$item['id']}?type=square";
            try {
                // Descarregar imatge
                $imageResponse = $client->get($imageUrl);
                $imageContent = $imageResponse->getBody()->getContents();

                // Detectar tipus d'imatge
                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($imageContent);

                // Assignar extensió segons el MIME type
                $extension = match ($mimeType) {
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    default => 'jpg',
                };

                // Nom de la imatge
                $imageName = "{$item['id']}.{$extension}";
                $imagePath = "cat_images/{$imageName}";

                // Guardar imatge al disc
                Storage::disk('public')->put($imagePath, $imageContent);

                // Guardar dades a la base de dades
                CatImage::create([
                    '_id' => $item['id'],
                    'mimetype' => $mimeType,
                    'size' => $item['size'] ?? null,
                    'tags' => json_encode($item['tags']),
                    'image_path' => $imagePath,
                ]);

            } catch (\Exception $e) {
                echo "Error en descarregar {$imageUrl}: " . $e->getMessage() . "\n";
            }
        }
    }
}
