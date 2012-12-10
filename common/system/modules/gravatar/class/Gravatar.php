<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

	class Gravatar
	{
		private $m_szImage;
		private $m_szEmail;
		private $m_iSize;
		private $m_szRating;
		
		const GRAVATAR_SITE_URL = 'http://www.gravatar.com/avatar.php?gravatar_id=%s&s=%s&d=%s&r=%s';
		
		public function __construct()
		{
			$this->m_iSize = 80;
			$this->m_szRating = 'R';
			$this->m_szImage = '';
		}
		
		public function getAvatar()
		{
			return (string) sprintf
			(
				self::GRAVATAR_SITE_URL,
				$this->m_szEmail,
				$this->m_iSize,
				$this->m_szImage,
				$this->m_szRating
			);
		}
		
		public function setImage($szImage)
		{
			$this->m_szImage = (string) urlencode($szImage);
			return $this;
		}
		
		public function setEmail($szEmail)
		{
			$this->m_szEmail = (string) md5($szEmail);
			return $this;
		}
		
		public function setSize($iSize)
		{
			$this->m_iSize = (int) $iSize;
			return $this;
		}
		
		public function setRatingAsG()
		{
			$this->m_szRating = 'G';
			return $this;
		}
		
		public function setRatingAsPG()
		{
			$this->m_szRating = 'PG';
			return $this;
		}
		
		public function setRatingAsR()
		{
			$this->m_szRating = 'R';
			return $this;
		}
		
		public function setRatingAsX()
		{
			$this->m_szRating = 'X';
			return $this;
		}
	}

?>