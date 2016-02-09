<?php
/**
 *
 * @filesource   ImageTest.php
 * @created      08.02.2016
 * @package      chillerlan\QRCodeTest\Output
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

namespace chillerlan\QRCodeTest\Output;

use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\Output\QRImageOptions;
use chillerlan\QRCode\QRCode;

class ImageTest extends \PHPUnit_Framework_TestCase{

	/**
	 * @var \chillerlan\QRCode\Output\QRImageOptions
	 */
	protected $options;


	/**
	 * @var \chillerlan\QRCode\QRCode
	 */
	protected $QRCode;

	protected function setUp(){
		$this->options = new QRImageOptions;
	}

	public function testOptionsInstance(){
		$this->assertInstanceOf(QRImageOptions::class, $this->options);
		$this->assertEquals(QRCode::OUTPUT_IMAGE_PNG, $this->options->type);
		$this->assertEquals(true, $this->options->base64);
	}

	public function testImageInstance(){
		$this->assertInstanceOf(QRImage::class, new QRImage);
	}

	public function testImageInstanceWithOptionsOverride(){
		$this->options->type = 'foobar';
		$this->options->pngCompression = 42;
		$this->options->jpegQuality = 'OVER 9000!!!';
		$this->assertInstanceOf(QRImage::class, new QRImage($this->options));
	}

	public function imageDataProvider(){
		return [
			['foobar', QRCode::OUTPUT_IMAGE_PNG, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHMAAABzCAIAAAAkIaqxAAAABnRSTlMA/wD/AP83WBt9AAACGUlEQVR4nO3cwU4DMQwAUYL4/19e7j54ZTmTuNW8G6K0MIqw0mZ3Pc/zI8Dv7V/ga1mWYlmKZSl/4eu11pkXLk3O0m8VnvnWX+SapViWYlmKZSlxggUbd2j5JOnMqJJjf5FrlmJZimUplqW8TLCAmzP5xil/qtKD85/NlZ7ZNUuxLMWyFMtSahPslnzOzPwozzVLsSzFshTLUqZMsNKMCg/u7ME4rlmKZSmWpViWUptg3HDoHL8Y8rFY4JqlWJZiWYplKS8T7NhBvnwf1flu/kIc1yzFshTLUixLWUPecws+8YOvwDVLsSzFshTLUl6uB9u4F+p8WnXsLOLGF3LNUixLsSzFspS4B9v4Jltnp7TxEuZjbzl6RfMhlqVYlmJZSuskB3eR8sa5WvrZ0vTLuWYplqVYlmJZSus0fekf/K2rkm+dxHfNUixLsSzFspTaXaXy//elWdF5odJ3bx0Kcc1SLEuxLMWylClnEbm90MadYc7PwQ6xLMWyFMtSwJMcuc7o2HjKsfNC+YNdsxTLUixLsSxlyr3pO7h9VIdrlmJZimUplqVMuTf9xtOG+ese23O6ZimWpViWYlnKlDv7Drl0ujMMA9csxbIUy1IsS5kywbi90MZ9Y2lUumYplqVYlmJZytB705ccOy/vXaVGsCzFshTLUj7y3vRB55pl7i1H1yzFshTLUixLmXI92PdxzVIsS7EsxbKUf5cMC/onT8WdAAAAAElFTkSuQmCC'],
			['foobar', QRCode::OUTPUT_IMAGE_GIF, 'data:image/gif;base64,R0lGODlhcwBzAIAAAAQCBP///yH5BAEAAAEALAAAAABzAHMAAAL+jI+py+0Po5y02ouz3rz7D4biSJYXgKbqyrbt5L5ITNerY+c0rCf6z8IBhwBezkcECpM9yQ/JPDaizchzRrUtUZ0bVmpVdcVT8sZ7uIZTY3bZfTYb1BC0xq7AY/D0h/4klxe4F9i3VcTxl1ZYNTf4xfUWuQjnCGY5ucDXGKCIiciwWdnJ6Uk62meqyoha+kiZeaoFCar5+gkVm3orW9u7Q3soHEwLDOub67s7mmxs23rZO3zsLC1ZM/1ZvQo9e3xYndwcI3497lIeypmuTU6s3o39/uxNr+zKPP/r/l3MKtOPGj9c5vyh07dtoDWBBwPaOweQIENdCkXVW/jQYET+jPviWbwXjRvFkP+CaAQ58qJIZIDyOeTILsPKNrFizkzEy5SRmghz8trJ8iUhlxKLCiJK4WYcpB+zyfSZJWE8m1HDnaxKderVqOCqlsya0utKsVpffiTLc6JXsCjbog1qYs3GuHRDWK2Ld+ncvHyH7u0LGKjOwEfDsnUaE7E+p00XOxZaEF7ajGa/RqZcB+rkwm0PX+YMVLHkzj2ZaoYL+nNXIn7lVTYdDaKSliotj77bjjVt10bHKpRtyAk+w9dwdxzSWirx279PAl/nfGvZ3JuVR1kd1rps7G6TcH8+/Thq60y+S19OfXxFrsVLao/OHPbf3t7h2/Mt3+Ro8Bv+jftvrhZj9QXYXn74VefecPrdd9qB6nmkoIMCGrheeMHFh2B4/JH22kXm7fdYeo11yJsfANJHYUMoZnciZ0oZtaFnag1GIGEhJtXihYDRmJmKLrbIF48m+hijjTcK1iCQeQn5IYNEnnddgegN2V+ObyWpoZTdpShWkzBpuZ2WWIF5pH3icTcmhhz2WOWTkFkgoXCxmZnYbl6iiWWGm4VGplwlhgmiXg/O96Ob6YlWQZx+/mcoR8uw6OOIMNJZWm0QRmrbpDViJp6knWbqaJ6DbtkmpKWu+eWmqc0I6qOoKsqpqxNOCaimsSo4K6q1pnorSfnJ6CStn8k6LKi7CnmMVoV6vipqnYGK2KqypP6pWqUlJmvhgGyOWiSJnpYn57LdrrhgqLr5met7qmLrYbVvJvqTmPGiGy5qfMIJHb5IOQvvvvL6S2/Ad8wbbLmt3TswwAUz6e7C7HmbYJaqbgguxJcKOzGUFZPLrq6UspoFWx3ze+a/VIgcMcaHGslyyy6/DHPMMs9Mc80WFAAAOw=='],
			// jpeg test is causing trouble
#			['foobar', QRCode::OUTPUT_IMAGE_JPG, 'data:image/jpg;base64,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'],
		];
	}

	/**
	 * @dataProvider imageDataProvider
	 */
	public function testImageOutput($data, $type, $expected){
		$this->options->type = $type;
		$this->assertEquals($expected, (new QRCode($data, new QRImage($this->options)))->output());
	}

	/**
	 * @expectedException \chillerlan\QRCode\Output\QRCodeOutputException
	 * @expectedExceptionMessage Invalid matrix!
	 */
	public function testSetMatrixException(){
		(new QRImage)->setMatrix([]);
	}

}
