<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

trait ImageHandling
{
    protected function handleImages(Model $model, array $newImages = [], array $imagesToRemove = [], $folder = 'default'): void
    {

        try {
            if ($model && !empty($newImages)) {
                foreach ($newImages as $image) {
                    $path = $image->store($folder, 'public');
                    $model->images()->create(['path' => $path]);
                }
            }

            if ($model && !empty($imagesToRemove)) {
                $instances = Image::whereIn('id', $imagesToRemove)->get();

                foreach ($instances as $instance) {
                    if (Storage::disk('public')->exists($instance->path)) {
                        Storage::disk('public')->delete($instance->path);
                    }
                    $instance->delete();
                }
            }
        } catch (Throwable $e) {
            throw $e;
        }
    }

    protected function deleteModelImages(Model $instance): void
    {
        if (method_exists($instance, 'images')) {
            try {
                $instance->load('images');

                foreach ($instance->images as $image) {
                    if (Storage::disk('public')->exists($image->path)) {
                        Storage::disk('public')->delete($image->path);
                    }

                    $image->delete();
                }
            } catch (Throwable $e) {
                throw $e;
            }
        }
    }
}
