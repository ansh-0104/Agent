<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnagramController extends Controller
{

    public function index(Request $request)
    {
        if($request->method("POST")){
        $s = $request->input('s');
        $p = $request->input('p');

        $result = $this->findAnagramIndices($s, $p);
        }

        return view('anagram', ['indices' => $result]);
    }

    public function findAnagrams(Request $request)
    {
        if($request->method("POST")){
        $s = $request->input('s');
        $p = $request->input('p');

        $result = $this->findAnagramIndices($s, $p);
        }

        return view('anagram', ['indices' => $result]);
    }

    private function findAnagramIndices($s, $p)
    {
        $sLength = strlen($s);
        $pLength = strlen($p);

        if ($sLength < $pLength) {
            return [];
        }

        $pMap = $this->buildFrequencyMap($p);
        $windowMap = $this->buildFrequencyMap(substr($s, 0, $pLength));
        $result = [];

        for ($i = 0; $i <= $sLength - $pLength; $i++) {
            if ($i > 0) {
                // Move the sliding window by removing the leftmost character
                $leftChar = $s[$i - 1];
                $windowMap[$leftChar]--;
                if ($windowMap[$leftChar] == 0) {
                    unset($windowMap[$leftChar]);
                }
                
                // Add the rightmost character to the window
                $rightChar = $s[$i + $pLength - 1];
                $windowMap[$rightChar] = ($windowMap[$rightChar] ?? 0) + 1;
            }

            // Check if the current window is an anagram of P
            if ($windowMap == $pMap) {
                $result[] = $i;
            }
        }

        return $result;
    }

    private function buildFrequencyMap($str)
    {
        $map = [];

        for ($i = 0; $i < strlen($str); $i++) {
            $map[$str[$i]] = ($map[$str[$i]] ?? 0) + 1;
        }

        return $map;
    }
}
