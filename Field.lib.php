<?php

class FieldEx extends Component {
	
	private static $idx = 0;
	
	private $name = 'field';
	private $type = '';
	
	public function ($name, $type = 'TextField')
	{
		if (empty($name)) {
			$name = $this->name . ++self::$idx;
		}
		
		$this->name = $name;
		$this->type = $type;
	}
	
	public function 
}

class Checkbox extends FieldEx {
<input name="mycolor" type="checkbox" value="red" checked>Красный(выбран по умолчанию) 
<input name="mycolor" type="checkbox" value="white">Белый
}

class Radio extends FieldEx {
<input name="mycolor" type="radio" value="white"> Белый
<input name="mycolor " type="radio" value="green" checked> Зеленый (выбран по умолчанию) 
}

class TextField extends FieldEx {
}

class DateField extends FieldEx {
}

class Select extends FieldEx {
}

class MultiField extends FieldEx {
}


<input type="reset" name="Reset" value="Очистить форму">

<select name="Имя списка" size = “Размер” multiple>
<option value=”Значение”>Отображаемый текст в списке</option>
</select>

<input type="text" name="txtName" size="10" maxlength="5" value="Текст по умолчанию">

<input type="password" name="txtName" size="10" maxlength="5">

<textarea name="txtArea" cols="15" rows="10" readonly> Текст, который 
изначально будет отображен в многострочном поле ввода и который 
нельзя изменять, т.к. указан атрибут readonly </textarea>

<input name="email" type="hidden" value="spam@nospam.ru">

