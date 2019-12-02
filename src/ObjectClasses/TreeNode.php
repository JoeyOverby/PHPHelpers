<?php declare(strict_types = 1);
/**
 * Created by Joey Overby
 * Date: 2019-03-21
 * Time: 14:49
 */

namespace JoeyOverby\PHPHelpers\ObjectClasses;


/**
 * Class TreeNode
 * This Binary Tree Node allows for helpful functions when building trees.
 */
class TreeNode {
    
    /** @var null $val */
    protected $val = null;
    /** @var TreeNode $left */
    protected $left = null;
    /** @var TreeNode $right */
    protected $right = null;
    
    /**
     * TreeNode constructor.
     *
     * @param               $value - The actual value for this tree node
     * @param TreeNode|null $left  - The left (child) node of this particular node
     * @param TreeNode|null $right - The right (child) node of this particular node
     */
    function __construct($value, TreeNode $left = null, TreeNode $right = null) {
        $this->val   = $value;
        $this->left  = $left;
        $this->right = $right;
        
    }
    
    /**
     * Returns true if it has a left element
     *
     * @return bool
     */
    public function hasLeft() : bool {
        if($this->getLeft() !== null) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns true if it has a right element
     *
     * @return bool
     */
    public function hasRight() : bool {
        if($this->getRight() !== null) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @return mixed|null
     */
    public function getVal() {
        return $this->val;
    }
    
    /**
     * @param null $val
     */
    public function setVal($val = null) : void {
        $this->val = $val;
    }
    
    /**
     * @return TreeNode|null
     */
    public function getLeft() : ?TreeNode {
        return $this->left;
    }
    
    /**
     * @param TreeNode|null $left
     */
    public function setLeft(TreeNode $left = null) : void {
        $this->left = $left;
    }
    
    /**
     * @return TreeNode|null
     */
    public function getRight() : ?TreeNode {
        return $this->right;
    }
    
    /**
     * @param TreeNode|null $right
     */
    public function setRight(TreeNode $right = null) : void {
        $this->right = $right;
    }
    
    /**
     * Returns true if this is a leaf node (has no children)
     *
     * @return bool
     */
    public function isLeaf() : bool {
        if($this->getRight() === null && $this->getLeft() === null) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Builds a TreeNode structure from the array (fitting the following array concept)
     * Array = [1,2,3,4,5,null,null,null,6]
     * Would give you:
     *              1
     *            /  \
     *           2    3
     *         /  \
     *        4    5
     *       / \
     *          6
     *
     * @param string[] $array
     *
     * @return TreeNode
     */
    public static function buildTree(array $array) : TreeNode {
        $nodes     = [];
        $nextRoots = new Queue();
        $toAdd     = new Queue($array);
        
        $realRoot              = new TreeNode($toAdd->pop());
        $nodes[$realRoot->val] = $realRoot;
        
        $nextRoots->push($realRoot);
        while($toAdd->size() > 0) {
            /** @var TreeNode $root */
            $root = $nextRoots->pop();
            if($toAdd->size() > 0) {
                
                $leftVal = $toAdd->pop();
                
                if($leftVal !== "null") {
                    $left              = new TreeNode($leftVal);
                    $nodes[$left->val] = $left;
                    $nextRoots->push($left);
                    $root->setLeft($left);
                }
                
            }
            
            if($toAdd->size() > 0) {
                $rightVal = $toAdd->pop();
                
                if($rightVal !== "null") {
                    $right              = new TreeNode($rightVal);
                    $nodes[$right->val] = $right;
                    $nextRoots->push($right);
                    $root->setRight($right);
                }
            }
            
            
        }
        
        return $realRoot;
        
    }
}