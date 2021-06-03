<?php

namespace App\Components\ShortestPath;

use Ds\Queue;
use Ds\Vector;

/**
 * @author Mohammed Mudassir <hello@mudasir.me>
 */
class BreadthFirstSearchAlgorithm
{
    // Space is undiscovered object. If it is empty then nothing is discover.
    protected Vector $space;

    // Queuing all the nodes to be process and discover edges.
    protected Queue $queue;

    // Paths are the adjacency list of all the shortest path.
    protected array $paths = [];

    // Limiting iteration as deeper we go with the nodes.
    protected int $depth = 5;

    /**
     * @param FacebookFriendAggregator $aggregator
     */
    public function __construct(protected FacebookFriendAggregator $aggregator)
    {
        $this->space = new Vector;
        $this->queue = new Queue;
    }

    /**
     * @param $origin
     * @param $destination
     * @return Vector
     */
    public function search($origin, $destination): Vector
    {
        $paths[$origin] = new Vector;

        // First get all the first node friends of origin's friend.
        $this->queue->push(...$edges = $this->aggregator->getNodeEdges($origin));
        $this->space->push($origin);

        foreach ($edges as $edge) {
            $this->paths[$edge] = new Vector;
            $this->paths[$edge]->push($origin);
        }

        while (! $this->queue->isEmpty()) {
            $node = $this->queue->pop();

            // Check if we have already processed the node.
            if ($this->hasNodeInSpace($node)) continue;

            $this->queue->push(...$edges = $this->aggregator->getNodeEdges($node));
            $this->space->push($node);

            foreach ($edges as $edge) {
                $this->paths[$edge] = clone $this->paths[$node];
                $this->paths[$edge]->push($node);

                // We found the shortest path. No need to proceed further.
                if ($edge == $destination) {
                    $this->paths[$edge]->push($destination);

                    break 2;
                }
            }
        }

        return $this->paths[$destination];
    }

    protected function hasNodeInSpace($node): bool
    {
        return ! empty($this->space->find($node));
    }
}
