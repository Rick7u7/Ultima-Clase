<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;

class GenerateLetterAvatars extends Command
{
    protected $signature = 'avatars:generate-letters';
    protected $description = 'Genera imágenes de letras A-Z como avatares';

    public function handle()
    {
        $outputPath = public_path('assets/avatars/letters');

        if (!File::exists($outputPath)) {
            File::makeDirectory($outputPath, 0755, true);
        }

        $fontPath = public_path('fonts/STENCIL.TTF');

        if (!File::exists($fontPath)) {
            $this->error("❌ Fuente no encontrada: {$fontPath}");
            return;
        }

        $manager = new ImageManager('gd');

        foreach (range('A', 'Z') as $letter) {
            $img = $manager->canvas(256, 256, '#f0f0f0');

            $img->text($letter, 128, 128, function ($font) use ($fontPath) {
                $font->file($fontPath);
                $font->size(120);
                $font->color('#333333');
                $font->align('center');
                $font->valign('center');
            });

            $img->save("{$outputPath}/{$letter}.png");
            $this->info("🖼️ Generado: {$letter}.png");
        }

        $this->info('✅ Avatares generados correctamente.');
    }
}
