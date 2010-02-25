<?

// make sure a session variable is set
session_start();

// create an image
$image = imagecreate(220, 36);

// set the background and foreground color
$bg = imagecolorallocate($image, 255, 230, 200);
$fg = imagecolorallocate($image, 40, 40, 100);
$lc = imagecolorallocate($image, 200, 180, 120);

// draw lines
$num = rand(10, 20);
for($i = 0; $i < $num; $i++)
{
	imageline($image, rand(0, 20), rand(-100, 160),
		rand(289, 299), rand(-100, 160), $lc);
}

// prepare the string
$_SESSION['key'] = "";
for($i = 0; $i < 8; $i++)
{
	$_SESSION['key'] .= chr(rand(ord('A'), ord('Z')));
}

// draw the key
for($i = 0; $i < strlen($_SESSION['key']); $i++)
{
	$size = rand(14, 20);
	imagettftext($image, $size, rand(-20, 20),
		($i * 26) + rand(0, 12), rand(24, 30),
		$fg, "./chics.ttf",
		substr($_SESSION['key'], $i, 1));
}

// output the result
imagepng($image);
imagedestroy($image);
header("Content-type: image/png");

?>
