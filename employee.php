<?php

	class Employee
	{
		private $conn;
		
		public function __construct($conn)
		{
			$this->conn = $conn;
		}
		
		public function getAllEmployees()
		{
			$query = "select * from employee";
			$result = mysqli_query($this->conn,$query);
			$employees = array();
			
			while($row = mysqli_fetch_assoc($result))
			{
				$employees[] = $row;
			}
			return $employees;
		}
		
		public function getEmployeeById($id)
		{
			$query = "select * from employee where id=$id";
			$result = mysqli_query($this->conn,$query);
			$employee = mysqli_fetch_assoc($result);
			return $employee;
		}
		
		public function addEmployee($data)
		{
			$emp_name = $data['emp_name'];
			$emp_code = $data['emp_code'];
			$emp_email = $data['emp_email'];
			$emp_phone = $data['emp_phone'];
			$emp_address = $data['emp_address'];
			$emp_designation = $data['emp_designation'];
			$emp_joining_date = $data['emp_joining_date'];
			
			$query = "insert into employee values('','$emp_name','$emp_code',
			'$emp_email','$emp_phone','$emp_address','$emp_designation',
			'$emp_joining_date')";
			$result = mysqli_query($this->conn,$query);

			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}	
		}
		public function updateEmployee($id,$data)
		{
			$emp_name = $data['emp_name'];
			$emp_email = $data['emp_email'];
			
			$query="update employee set emp_name='$emp_name',emp_email='$emp_email' where id='$id'";
			$result = mysqli_query($this->conn,$query);

			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
			public function deleteEmployee($id)
		{
	
			$query="delete from employee where id='$id'";
			$result = mysqli_query($this->conn,$query);
			
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
?>