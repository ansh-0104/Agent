<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SegmentTreeController extends Controller
{
    private $segmentTree;

    public function __construct()
    {
        // Example initial array
        $initialArray = [1, 2, 3, 4, 5];
        $this->segmentTree = new SegmentTree($initialArray);
    }

    public function index()
    {
        return view('segment_tree.index', ['array' => $this->segmentTree->getArray()]);
    }

    public function initialize(Request $request)
    {
        $size = $request->input('size', 0);
        $inputArray = explode(',', $request->input('array', ''));

        $validator = Validator::make(
            ['size' => $size, 'array' => $inputArray],
            ['size' => 'required|integer|min:1', 'array' => 'required|array'],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->segmentTree = new SegmentTree($inputArray);

        return view('segment_tree.index', ['array' => $this->segmentTree->getArray()]);
    }

    public function query(Request $request)
    {
        // return $request->all();
        $i = $request->input('i');
        $j = $request->input('j');

        $result = $this->segmentTree->query($i, $j);

        return response()->json(['sum' => $result]);
    }

    public function update(Request $request)
    {
        $index = $request->input('index');
        $value = $request->input('value');

        $this->segmentTree->update($index, $value);
        $updatedArray = $this->segmentTree->getArray();

        return response()->json(['message' => 'Update successful', 'array' => $updatedArray]);
    }
}

class SegmentTree
{
    private $tree;
    private $arr;
    private $n;

    public function __construct($arr)
    {
        $this->arr = $arr;
        $this->n = count($arr);
        $this->tree = array_fill(1, $this->n * 4, 0); // Use an array to represent the segment tree
        $this->buildSegmentTree();
    }

    private function buildSegmentTree($node = 1, $start = 0, $end = null)
    {
        if ($end === null) {
            $end = $this->n - 1;
        }

        if ($start == $end) {
            $this->tree[$node] = $this->arr[$start];
            return;
        }

        $mid = (int)(($start + $end) / 2); // Use integer division
        $leftChild = 2 * $node;
        $rightChild = 2 * $node + 1;

        $this->buildSegmentTree($leftChild, $start, $mid);
        $this->buildSegmentTree($rightChild, $mid + 1, $end);

        $this->tree[$node] = $this->tree[$leftChild] + $this->tree[$rightChild];
    }


    public function update($index, $newValue, $node = 1, $start = 0, $end = null)
    {
        if ($end === null) {
            $end = $this->n - 1;
        }

        if ($start == $end) {
            $this->arr[$index] = $newValue;
            $this->tree[$node] = $newValue;
            return;
        }

        $mid = (int)(($start + $end) / 2);
        $leftChild = 2 * $node;
        $rightChild = 2 * $node + 1;

        if ($index <= $mid) {
            $this->update($index, $newValue, $leftChild, $start, $mid);
        } else {
            $this->update($index, $newValue, $rightChild, $mid + 1, $end);
        }

        $this->tree[$node] = $this->tree[$leftChild] + $this->tree[$rightChild];
    }

    public function query($i, $j, $node = 1, $start = 0, $end = null)
    {
        if ($end === null) {
            $end = $this->n - 1;
        }

        // If the current segment is completely outside the query range
        if ($i > $end || $j < $start) {
            return 0;
        }

        // If the current segment is completely inside the query range
        if ($i <= $start && $j >= $end) {
            return $this->tree[$node];
        }

        // If the current segment partially overlaps with the query range
        $mid = (int)(($start + $end) / 2);
        $leftChild = 2 * $node;
        $rightChild = 2 * $node + 1;

        $leftSum = $this->query($i, min($mid, $j), $leftChild, $start, $mid);
        $rightSum = $this->query(max($mid + 1, $i), $j, $rightChild, $mid + 1, $end);

        return $leftSum + $rightSum;
    }


    public function getArray()
    {
        return $this->arr;
    }

    public function getSize()
    {
        return $this->n;
    }
}
