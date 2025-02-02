<?php
	class Document
	{
		//vars
		public $id;
		public $collection;
		public $title;
		public $libraryindex;

		public $startday;
		public $startmonth;
		public $startyear;
		public $endday;
		public $endmonth;
		public $endyear;
		public $comments;
		public $needsreview; //bool
		public $needsinput; //bool
		public $fronturl;
		public $backurl;
		public $frontimage;
		public $backimage;
		public $frontthumbnail;
		public $backthumbnail;
		public $xmlfile;
		public $url = "../Images/Newbie/Documents/";
		public $thumb_url = "../Images/Newbie/Thumbnails/";
		public $completed;
	}

	class JobFolder extends Document
	{
		public $author;
		public $inasubfolder; //bool
		public $subfoldercomments;
		public $classification;
		public $classificationcomments;

        public function __construct($collection,$xmlpath,$username,$mapid)
		{
			$this->xmlfile = $xmlpath;
			$found = -1;
			$this->collection = $collection;
			$this->id = $mapid;

			$xml = simplexml_load_file($this->xmlfile) or die("Cannot open file!");
			foreach($xml->document as $a)
			{
				if($a->id == $this->id)
				{
					$this->title = $a->title;
					$this->needsreview = $a->needsreview;
					$this->needsinput = $a->needsinput;
					$this->inasubfolder = $a->inasubfolder;
					$this->subfoldercomments = $a->subfoldercomments;
					$this->classification = $a->classification;
					$this->classificationcomments = $a->classificationcomments;
					$this->comments = $a->comments;
					$this->startday = $a->startday;
					$this->startmonth = $a->startmonth;
					$this->startyear = $a->startyear;
					$this->endday = $a->endday;
					$this->endmonth = $a->endmonth;
					$this->endyear = $a->endyear;
					$this->author = $a->author;
					$this->completed = $a->completed;

					$this->libraryindex = $a->libraryindex;
					$this->frontimage = $this->url. $a->frontimage;
					$this->backimage = $this->url. $a->backimage;
					$this->frontthumbnail = $this->thumb_url. $a->frontthumbnail;
					$this->backthumbnail = $this->thumb_url. $a->backthumbnail;
					$found = 1;
				}
				if($found == 1)
					break;
			}

		}

	}

	class Map extends Document
	{

	}

?>