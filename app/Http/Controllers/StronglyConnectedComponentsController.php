<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StronglyConnectedComponentsController extends Controller
{
    public function index()
    {
        return view('scc.index');
    }

    public function findSCC(Request $request)
    {
        $graphData = $request->input('graph_data');

        // Validate and process the input
        $graph = $this->processGraphData($graphData);

        // Find strongly connected components
        $stronglyConnectedComponents = $this->tarjanSCC($graph);

        return view('scc.index', ['graphData' => $graphData, 'scc' => $stronglyConnectedComponents]);
    }

    protected function processGraphData($graphData)
    {
        // Process the input and convert it to an adjacency list
        $graph = [];

        foreach (explode(PHP_EOL, $graphData) as $line) {
            $line = trim($line);

            // Check if the line is not empty and contains ' -> '
            if (!empty($line) && strpos($line, ' -> ') !== false) {
                // Split the line into node and neighbors
                [$node, $neighbors] = explode(' -> ', $line);

                // Check if both node and neighbors are set before assigning to the graph array
                if (isset($node) && isset($neighbors)) {
                    $graph[$node] = explode(', ', $neighbors);
                }
            }
        }

        return $graph;
    }


    protected function tarjanSCC($graph)
    {
        $index = 0;
        $stack = collect();
        $lowlink = [];
        $indexMap = [];
        $result = [];

        foreach (array_keys($graph) as $node) {
            if (!isset($indexMap[$node])) {
                $this->strongConnect($node, $index, $stack, $lowlink, $indexMap, $result, $graph);
            }
        }

        return $result;
    }

    protected function strongConnect($node, &$index, $stack, &$lowlink, &$indexMap, &$result, $graph)
    {
        $indexMap[$node] = $index;
        $lowlink[$node] = $index;
        $index++;

        $stack->push($node);

        if (isset($graph[$node])) {
            foreach ($graph[$node] as $neighbor) {
                if (!isset($indexMap[$neighbor])) {
                    $this->strongConnect($neighbor, $index, $stack, $lowlink, $indexMap, $result, $graph);
                    $lowlink[$node] = min($lowlink[$node], $lowlink[$neighbor]);
                } elseif ($stack->contains($neighbor)) {
                    $lowlink[$node] = min($lowlink[$node], $indexMap[$neighbor]);
                }
            }
        }

        if ($lowlink[$node] == $indexMap[$node]) {
            $component = [];
            do {
                $current = $stack->pop();
                $component[] = $current;
            } while ($current !== $node);

            $result[] = $component;
        }
    }
}
