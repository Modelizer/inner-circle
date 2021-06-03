<?php

namespace App\Components\ShortestPath;

use App\Models\FacebookFriend;
use Ds\Queue;
use Ds\Vector;
use Illuminate\Support\Collection;

/**
 * @author Mohammed Mudassir <hello@mudasir.me>
 */
class BreadthFirstSearchAlgorithm
{
    protected Queue $queue;

    protected array $visited = [];

    protected array $path = [];

    public function __construct(protected FacebookFriendAggregator $aggregator)
    {
        $this->queue = new Queue();
    }

    public function search($origin, $destination): Vector
    {
        if ($node = $this->aggregator->findNode($origin, $destination)) {
            $path = new Vector;
            $path->push($destination);
            $path->push($origin);

            return $path;
        }

        // Space is undiscovered object. If it is empty then nothing is discover.
        $space = new Vector;
        $queue = new Queue;

        // Paths are the adjacency list of all the shortest path.
        $paths = [];
        $paths[$origin] = new Vector;

        // First get all the first node friends of origin's friend.
        $queue->push(...$edges = $this->aggregator->getNodeEdges($origin));
        $space->push($origin);

        foreach ($edges as $edge) {
            $paths[$edge] = new Vector;
            $paths[$edge]->push($origin);
        }

        while (! $queue->isEmpty()) {
            // Check if we have already processed the node.
            if (! empty($space->find($node = $queue->pop()))) {
                continue;
            }

            $queue->push(...$edges = $this->aggregator->getNodeEdges($node));
            $space->push($node);

            foreach ($edges as $edge) {
                $paths[$edge] ??= new Vector;
                $paths[$edge]->push($node);
            }
        }

        return $paths[$destination];
    }
}
