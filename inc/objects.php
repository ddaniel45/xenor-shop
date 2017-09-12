<?php
	class catalogue {
		public $name;
		public $towhere;
		
		public function __construct($name,$towhere) {
			$this->name = $name;
			$this->towhere = $towhere;
		}
	}
	
	class category {
		public $name;
		
		public function __construct($name) {
			$this->name = $name;
		}
	}
	
	class subcategory {
		public $name;
		public $catid;
		
		public function __construct($name,$catid) {
			$this->name = $name;
			$this->catid = $catid;
		}
	}
	
	class subcatalogue {
		public $name;
		public $catid;
		public $towhere;
		
		public function __construct($name,$catid,$towhere) {
			$this->name = $name;
			$this->towhere = $towhere;
			$this->catid = $catid;
		}
	}
	
	class article {
		public $catid;
		public $subcatid;
		public $name;
		public $specs;
		public $imgs;
		public $rating;
		
		
		public function __construct($catid,$subcatid,$name,$specs,$imgs,$rating) {
			$this->catid = $catid;
			$this->subcatid = $subcatid;
			$this->name= $name;
			$this->specs = $specs;
			$this->imgs = $imgs;
			$this->rating = $rating;
		}
	}
?>
