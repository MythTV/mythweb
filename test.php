<html>
<body>

<?

class test {

	function test() {
		static $x = 0;
		$x++;
		echo "$x<p>\n";
	}

	function x() {
		echo "test";
	}
}

class foo extends test {

	function x() {
		parent::x();
		echo "foo";
	}

}

$a = new foo;
$a->x();

?>

</body>
</html>

