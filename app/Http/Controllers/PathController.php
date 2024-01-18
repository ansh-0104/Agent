<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PathController extends Controller
{
    public function findLeastExpensivePath(Request $request)
    {
        $grid = $request->input('grid');

        // Validate and process the input grid
        $matrix = $this->processGrid($grid);

        // Find the least expensive path
        $result = $this->dijkstra($matrix);

        return view('path.index', ['result' => $result]);
        // return response()->json(['result' => $result]);
    }

    protected function processGrid($grid)
    {
        // If $grid is a string, attempt to convert it to an array
        if (is_string($grid)) {
            // You can customize the logic to convert the string to an array based on your input format
            $grid = explode("\n", trim($grid));
        }

        // Validate that $grid is an array
        if (!is_array($grid)) {
            // Handle the case where $grid is not an array (throw an exception, return an error response, etc.)
            // For simplicity, we'll assume a default grid if it's not an array
            $grid = [
                '1 2 3',
                '4 5 6',
                '7 8 9',
            ];
        }

        // Process the input and convert it to a 2D matrix
        $matrix = [];

        foreach ($grid as $row) {
            // Convert each row to an array of integers
            $matrix[] = array_map('intval', explode(' ', $row));
        }

        return $matrix;
    }




    protected function dijkstra($matrix)
    {
        $rows = count($matrix);
        $cols = count($matrix[0]);

        $distances = [];
        $visited = [];

        // Initialize distances and visited array
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $distances[$i][$j] = PHP_INT_MAX;
                $visited[$i][$j] = false;
            }
        }

        // Dijkstra's algorithm
        $distances[0][0] = $matrix[0][0];

        for ($count = 0; $count < $rows * $cols - 1; $count++) {
            $u = $this->minDistance($distances, $visited, $rows, $cols);
            $visited[$u['i']][$u['j']] = true;

            // Update distances
            $this->updateDistances($matrix, $distances, $visited, $u['i'], $u['j'], $rows, $cols);
        }

        return $distances[$rows - 1][$cols - 1];
    }

    protected function minDistance($distances, $visited, $rows, $cols)
    {
        $min = PHP_INT_MAX;
        $minIndex = ['i' => 0, 'j' => 0];

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                if (!$visited[$i][$j] && $distances[$i][$j] <= $min) {
                    $min = $distances[$i][$j];
                    $minIndex['i'] = $i;
                    $minIndex['j'] = $j;
                }
            }
        }

        return $minIndex;
    }

    protected function updateDistances($matrix, &$distances, $visited, $i, $j, $rows, $cols)
    {
        // Possible moves: right, down, left, up
        $rowMoves = [0, 1, 0, -1];
        $colMoves = [1, 0, -1, 0];

        for ($k = 0; $k < 4; $k++) {
            $newI = $i + $rowMoves[$k];
            $newJ = $j + $colMoves[$k];

            if (
                $this->isValidMove($newI, $newJ, $rows, $cols) &&
                !$visited[$newI][$newJ] &&
                $distances[$i][$j] + $matrix[$newI][$newJ] < $distances[$newI][$newJ]
            ) {
                $distances[$newI][$newJ] = $distances[$i][$j] + $matrix[$newI][$newJ];
            }
        }
    }

    protected function isValidMove($i, $j, $rows, $cols)
    {
        return $i >= 0 && $i < $rows && $j >= 0 && $j < $cols;
    }
}
