<?php
class User extends SQLClass
{
	protected function initializeValues($_pass_to_intiliazing=FALSE)
	{
		$this->addColumn($_name="id");
		$this->addColumn($_name="username", $type=false, $_value="", $_size=64, $_empty=false);
		$this->addColumn($_name="password", $type=false, $_value="", $_size=255, $_empty=false);
		$this->addColumn($_name="group", $type=false, $_value="", $_size=64, $_empty=false);
		$this->_table = "users";
	}
		
	protected function Before_COMMIT()
	{
		$this->setValue("password",passwordHash($this->getValue("password")));
	}
	
	public function checkPassword($_password)
	{
		if($this->inDataspace())
		{
			return checkPassword($_password ,$this->getValue("password"));
		}else return FALSE;
	}
}
?>