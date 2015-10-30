<?php
/**
 * @author Lemmy
 */
class ComponentLabel extends Component
{
	/**
	 * The directory in which the font files are located.
	 */
	const FONT_DIRECTORY = 'fonts/';

	/**
	 * fonts/exo2regular.ttf
	 */
	const FONT_REGULAR = 'exo2regular.ttf';

	/**
	 * fonts/exo2medium.ttf
	 */
	const FONT_MEDIUM = 'exo2medium.ttf';

	/**
	 * fonts/exo2bold.ttf
	 */
	const FONT_BOLD = 'exo2bold.ttf';

	/**
	 * fonts/osu!font.ttf
	 */
	const FONT_OSU = 'osu!font.ttf';

	/**
	 * The text of this label
	 *
	 * @var string
	 */
	private $text;

	/**
	 * The font file to use for this label
	 *
	 * @var string
	 */
	private $font;

	/**
	 * The colour of the text of the label
	 *
	 * @var string
	 */
	private $colour;

	/**
	 * The size of the font of this label
	 *
	 * @var float
	 */
	private $fontSize;

	/*
	 * The alignment of this text
	 *
	 * @var int
	 */
	private $textAlignment;

	/**
	 * The predefined or calculated width of this label
	 *
	 * @var int
	 */
	private $width;

	/**
	 * The predefined or calculated height of this label
	 *
	 * @var int
	 */
	private $height;

	/**
	 * The Draw instance for this label, with all data set in the constructor
	 *
	 * @var ImagickDraw
	 */
	private $drawSettings;

	/**
	 * Creates a new Label component.
	 *
	 * @param int $x The X position of this label
	 * @param int $y The Y position of this label
	 * @param $text The text of this label
	 * @param string $font The font to use for this label; can be a string or the constants defined in {@link ComponentLabel}
	 * @param string $colour The colour of the text of the label
	 * @param int $fontSize The size of the font of the label
	 * @param int $textAlignment The text alignment
	 * @param int $width Width of the label, set to -1 to use the text size, anything bigger can be used to spoof the component system
	 * @param int $height Height of the label, set to -1 to use the text size, anything bigger can be used to spoof the component system
	 */
	public function __construct(
		$x = 0,
		$y = 0,
		$text,
		$font = 'exo2regular.ttf',
		$colour = '#555555',
		$fontSize = 14,
		$textAlignment = Imagick::ALIGN_UNDEFINED,
		$width = -1,
		$height = -1) {

		$this->text = $text;
		$this->font = $font;
		$this->colour = $colour;
		$this->fontSize = $fontSize;
		$this->textAlignment = $textAlignment;
		$this->width = $width;
		$this->height = $height;

		$this->drawSettings = new ImagickDraw();
		$this->drawSettings->setFont($font);
		$this->drawSettings->setFontSize($fontSize);
		$this->drawSettings->setTextAlignment($textAlignment);
		$this->drawSettings->setFillColor($colour);

		if ($width <= -1 || $height <= -1) {
			$tempImg = new Imagick();
			$metrics = $tempImg->queryFontMetrics($this->drawSettings, $this->text);

			$this->width = $width <= -1 ? $metrics['textWidth'] : $width;
			$this->height = $height <= -1 ? $metrics['textHeight'] : $height;
		}

		parent::__construct($x, $y);
	}

	public function getWidth() {
		return $this->width;
	}

	public function getHeight() {
		return $this->height;
	}

	public function draw(OsuSignature $signature)
	{
		if (isset($this->text)) {
			$signature->getCanvas()->annotateImage($this->drawSettings, $this->x, $this->y, 0, $this->text);
		}
	}
}