<?php

namespace App\Services;

use DB;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\QueryException;

class Option
{
    protected $items;

    public function __construct(Filesystem $filesystem)
    {
        $cachePath = storage_path('options/cache.php');
        if ($filesystem->exists($cachePath)) {
            $this->items = collect($filesystem->getRequire($cachePath));
            return;
        }

        try {
            $this->items = DB::table('options')->get()->mapWithKeys(function ($item) {
                return [$item->k => $item->v];
            });
        } catch (QueryException $e) {
            $this->items = collect();
        }
    }

    public function get($key, $default = null, $raw = false)
    {
        if (! $this->items->has($key) && Arr::has(config('options'), $key)) {
            $this->set($key, config("options.$key"));
        }

        $value = $this->items->get($key, $default);
        if ($raw) {
            return $value;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'null':
            case '(null)':
                return null;

            default:
                return $value;
        }
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        } else {
            $this->items->put($key, $value);
            try {
                DB::table('options')->updateOrInsert(
                    ['k' => $key],
                    ['v' => $value]
                );
            } catch (QueryException $e) {
                //
            }
        }
    }

    public function has($key)
    {
        return $this->items->has($key);
    }

    public function all(): array
    {
        return $this->items->all();
    }
}
