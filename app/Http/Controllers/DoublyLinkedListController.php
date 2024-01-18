<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoublyLinkedListController extends Controller
{
    //
    private $head;

    public function __construct()
    {
        $this->head = null;
    }

    public function index()
    {
        $listArray = $this->getListAsArray();
        return view('doubly_linked_list.index', compact('listArray'));
    }

    public function addNodeToEnd(Request $request)
    {
        // Get the existing list from the form input
        $inputList = $request->input('list');

        // Convert the comma-separated values to an array
        $existingList = explode(',', $inputList);

        // Create a doubly linked list from the existing values
        $this->head = null;

        foreach ($existingList as $value) {
            $newNode = new Node(trim($value));

            if ($this->head === null) {
                $this->head = $newNode;
            } else {
                $current = $this->head;

                while ($current->next !== null) {
                    $current = $current->next;
                }

                $current->next = $newNode;
                $newNode->prev = $current;
            }
        }

        // Add the new node to the end
        $newValue = $request->input('value');
        $newNode = new Node($newValue);

        if ($this->head !== null) {
            $current = $this->head;

            while ($current->next !== null) {
                $current = $current->next;
            }

            $current->next = $newNode;
            $newNode->prev = $current;
        } else {
            $this->head = $newNode;
        }

        // After adding the node to the linked list, update the array
        $listArray = $this->getListAsArray();

        return view('doubly_linked_list.index', compact('listArray'));
    }








    public function deleteNode(Request $request)
    {
        $deleteIndex = $request->input('deleteIndex');
        $inputList = $request->input('list');

        // Convert the comma-separated values to an array
        $existingList = explode(',', $inputList);

        // Create a doubly linked list from the existing values
        $this->head = null;

        foreach ($existingList as $value) {
            $newNode = new Node(trim($value));

            if ($this->head === null) {
                $this->head = $newNode;
            } else {
                $current = $this->head;

                while ($current->next !== null) {
                    $current = $current->next;
                }

                $current->next = $newNode;
                $newNode->prev = $current;
            }
        }

        if ($this->head === null || $deleteIndex < 0) {
            // Handle edge cases or return an error
            return redirect()->route('doubly_linked_list.index');
        }

        $current = $this->head;

        for ($i = 0; $i < $deleteIndex && $current !== null; $i++) {
            $current = $current->next;
        }

        if ($current === null) {
            // Handle edge cases or return an error
            return redirect()->route('doubly_linked_list.index');
        }

        if ($current->prev !== null) {
            $current->prev->next = $current->next;
        } else {
            $this->head = $current->next;
        }

        if ($current->next !== null) {
            $current->next->prev = $current->prev;
        }

        // After deleting the node, update the array
        $listArray = $this->getListAsArray();

        return view('doubly_linked_list.index', compact('listArray'));
    }



    public function rotate(Request $request)
    {
        $steps = $request->input('steps', 0);
        $direction = $request->input('direction', 'clockwise');
        $inputList = $request->input('list');

        // Convert the comma-separated values to an array
        $existingList = explode(',', $inputList);

        // Create a doubly linked list from the existing values
        $this->head = null;

        foreach ($existingList as $value) {
            $newNode = new Node(trim($value));

            if ($this->head === null) {
                $this->head = $newNode;
            } else {
                $current = $this->head;

                while ($current->next !== null) {
                    $current = $current->next;
                }

                $current->next = $newNode;
                $newNode->prev = $current;
            }
        }

        if ($this->head === null || $steps == 0) {
            // Handle edge cases or return an error
            return redirect()->route('doubly_linked_list.index');
        }

        if ($direction === 'clockwise') {
            for ($i = 0; $i < $steps; $i++) {
                $lastNode = $this->removeLastNode();
                $this->insertNodeAtBeginning($lastNode);
            }
        } elseif ($direction === 'anticlockwise') {
            for ($i = 0; $i < $steps; $i++) {
                $firstNode = $this->removeFirstNode();
                $this->insertNodeAtEnd($firstNode);
            }
        }

        // After rotating the list, update the array
        $listArray = $this->getListAsArray();

        return view('doubly_linked_list.index', compact('listArray'));
    }


    private function getListAsArray()
    {
        $listArray = [];
        $current = $this->head;

        while ($current !== null) {
            $listArray[] = [
                'data' => $current->data,
                'prev' => $current->prev !== null ? $current->prev->data : null,
            ];
            $current = $current->next;
        }

        return $listArray;
    }

    private function removeLastNode()
    {
        $current = $this->head;

        while ($current->next !== null) {
            $current = $current->next;
        }

        $lastNode = $current;

        if ($lastNode->prev !== null) {
            $lastNode->prev->next = null;
        } else {
            $this->head = null;
        }

        return $lastNode;
    }

    private function insertNodeAtBeginning($newNode)
    {
        $newNode->next = $this->head;
        $newNode->prev = null;

        if ($this->head !== null) {
            $this->head->prev = $newNode;
        }

        $this->head = $newNode;
    }

    private function removeFirstNode()
    {
        $firstNode = $this->head;

        if ($firstNode->next !== null) {
            $firstNode->next->prev = null;
            $this->head = $firstNode->next;
        } else {
            $this->head = null;
        }

        return $firstNode;
    }

    private function insertNodeAtEnd($newNode)
    {
        $current = $this->head;

        while ($current->next !== null) {
            $current = $current->next;
        }

        $current->next = $newNode;
        $newNode->prev = $current;
        $newNode->next = null;
    }
}


class Node
{
    public $data;
    public $prev;
    public $next;

    public function __construct($data)
    {
        $this->data = $data;
        $this->prev = null;
        $this->next = null;
    }
}
