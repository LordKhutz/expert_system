<?PHP

class expert
{
public $facts;
public $query;
public $operations = array();
public $vars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
public $vars_value = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
public $rules = array();
public function __construct($file)
{
	foreach ($file as $line)
	{
		$j = 0;
		$this->read_line($line);
		$line = trim($line);
		$arr1 = array_filter(str_split($line));
		if($arr1[$j] === '=')
		{
			$i = 0;
			for ($j=0;$j < count($arr1);$j++)
			{
				for ($i = 0; $i < 26; $i++)
				{
					if ($arr1[$j] === $this->vars[$i])
					{
						$this->vars_value[$i] = 1;
					}
				}
			}
		}
	}
	//$this->change_rules();
}

public function getvars()
{
	$counter = 0;
	echo $this->facts."<br>";
	echo $this->query."<br>";
	//echo count($this->operations[2]).'<br>';
	foreach ($this->rules as $i)
	{
		echo '<pre>';
		print_r($i);
		echo '</pre>';
	}
	echo '<table><tr><td>Fact</td><td>State</td></tr>';
	foreach($this->vars_value as $v)
	{
		echo '<tr><td>'.$this->vars[$counter].'</td><td>'.$v."</td><tr>";
		$counter++;
	}
	echo '</table>';
}

private function read_line($line)
{
	$line = trim($line);
	if($line[0] != '#')
	{
	if(preg_match('/^(.*?)#/',$line, $ret))
	{
		$ret = preg_replace("/#/" , "\0" , $ret);
		$ret[0] =  preg_replace('/\s\s+/', '', $ret[0]);
		$ret[0] = str_replace(' ', '', $ret[0]);
		$this->show($ret[0]);
	}
	else
	{
		$line =  preg_replace('/\s\s+/', '', $line);
		$line = str_replace(' ', '' , $line);
		$this->show($line);
	}
	}
}

private function show($line)
{
	if($line[0] === '=')
	{
		$this->facts = $line;
	}
	else if($line[0] === '?')
		$this->query = $line;
	else 
		array_push($this->rules, $line);
}

public function change_rules()
{
    $i = 0;
    while ($this->rules[$i]) {
        $this->rules[$i] = preg_replace('/=>/', '=', $this->rules[$i]);
        $this->rules[$i] = preg_replace('/<=/', '_', $this->rules[$i]);
        $i++;
    }
}
}
?>
