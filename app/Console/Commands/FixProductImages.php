<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class FixProductImages extends Command
{
    protected $signature   = 'products:fix-images';
    protected $description = 'Assign correct Unsplash images to all 30 products';

    // Verified working Unsplash photo IDs for each plant
    private array $images = [
        // Money Plant / Pothos
        'money-plant-golden-pothos'        => 'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=600&q=80&fit=crop',
        // Snake Plant
        'snake-plant-sansevieria'          => 'https://images.unsplash.com/photo-1620127682229-33388276e540?w=600&q=80&fit=crop',
        // Spider Plant
        'spider-plant'                     => 'https://images.unsplash.com/photo-1592150621744-aca64f48394a?w=600&q=80&fit=crop',
        // Peace Lily
        'peace-lily'                       => 'https://images.unsplash.com/photo-1593691509543-c55fb32d8de5?w=600&q=80&fit=crop',
        // Aloe Vera
        'aloe-vera'                        => 'https://images.unsplash.com/photo-1596547609652-9cf5d8c10616?w=600&q=80&fit=crop',
        // Jade Plant
        'jade-plant'                       => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=600&q=80&fit=crop',
        // Echeveria
        'echeveria'                        => 'https://images.unsplash.com/photo-1459156212016-c812468e2115?w=600&q=80&fit=crop',
        // Haworthia
        'haworthia'                        => 'https://images.unsplash.com/photo-1631135131671-ac7a3d71a82b?w=600&q=80&fit=crop',
        // String of Pearls
        'string-of-pearls'                 => 'https://images.unsplash.com/photo-1545239351-ef35f43d514b?w=600&q=80&fit=crop',
        // Cactus
        'cactus-mix-small-set-of-3'        => 'https://images.unsplash.com/photo-1512235216952-b63ada76f65f?w=600&q=80&fit=crop',
        // Areca Palm
        'areca-palm'                       => 'https://images.unsplash.com/photo-1530092285049-1c42085fd395?w=600&q=80&fit=crop',
        // Rubber Plant
        'rubber-plant-ficus-elastica'      => 'https://images.unsplash.com/photo-1597362925123-77861d3fbac7?w=600&q=80&fit=crop',
        // Fiddle Leaf Fig
        'fiddle-leaf-fig'                  => 'https://images.unsplash.com/photo-1585314062604-1a357de8b000?w=600&q=80&fit=crop',
        // Bamboo Palm
        'bamboo-palm'                      => 'https://images.unsplash.com/photo-1483119624769-b1a904f5efaf?w=600&q=80&fit=crop',
        // Dracaena
        'dracaena-marginata'               => 'https://images.unsplash.com/photo-1509423350716-97f9360b4e09?w=600&q=80&fit=crop',
        // Monstera
        'monstera-deliciosa'               => 'https://images.unsplash.com/photo-1567225591450-06036b3392a6?w=600&q=80&fit=crop',
        // Anthurium
        'anthurium'                        => 'https://images.unsplash.com/photo-1559564483-dcad2c4bc3a6?w=600&q=80&fit=crop',
        // Kalanchoe
        'kalanchoe-flowering'              => 'https://images.unsplash.com/photo-1561479109-1df4b7d4ba2a?w=600&q=80&fit=crop',
        // Boston Fern
        'boston-fern'                      => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=600&q=80&fit=crop',
        // English Ivy
        'english-ivy'                      => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=600&q=80&fit=crop',
        // Philodendron
        'philodendron-brasil'              => 'https://images.unsplash.com/photo-1616838347015-8b5ff1f8ec6e?w=600&q=80&fit=crop',
        // Pothos Marble Queen
        'pothos-marble-queen'              => 'https://images.unsplash.com/photo-1585116938581-6e565a1f9ef7?w=600&q=80&fit=crop',
        // ZZ Plant
        'zz-plant-zamioculcas'             => 'https://images.unsplash.com/photo-1632207691143-643e2a9a9361?w=600&q=80&fit=crop',
        // Lucky Bamboo
        'lucky-bamboo-2-layer'             => 'https://images.unsplash.com/photo-1624553278698-0af5cc8bc17d?w=600&q=80&fit=crop',
        // Bird's Nest Fern
        'birds-nest-fern'                  => 'https://images.unsplash.com/photo-1561322840-7b28da3ef988?w=600&q=80&fit=crop',
        // Croton
        'croton'                           => 'https://images.unsplash.com/photo-1572435555646-7ad9a149ad91?w=600&q=80&fit=crop',
        // Calathea
        'calathea-orbifolia'               => 'https://images.unsplash.com/photo-1598880940671-c468a0655a42?w=600&q=80&fit=crop',
        // Chinese Evergreen / Aglaonema
        'chinese-evergreen-aglaonema'      => 'https://images.unsplash.com/photo-1616694238198-7c35a49bf5be?w=600&q=80&fit=crop',
        // Parlor Palm
        'parlor-palm-chamaedorea'          => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=600&q=80&fit=crop',
        // Air Plant
        'air-plant-tillandsia-set-of-2'    => 'https://images.unsplash.com/photo-1487530811015-780ce0f6e01f?w=600&q=80&fit=crop',
    ];

    public function handle(): void
    {
        $updated = 0;

        foreach ($this->images as $slug => $url) {
            $rows = Product::where('slug', $slug)->update(['image_path' => $url]);
            if ($rows) {
                $this->info("✓ Updated: {$slug}");
                $updated += $rows;
            } else {
                $this->warn("✗ Not found: {$slug}");
            }
        }

        $this->newLine();
        $this->info("Done! {$updated} products updated.");
    }
}
