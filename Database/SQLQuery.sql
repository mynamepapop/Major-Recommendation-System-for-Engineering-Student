/*แสดงข้อมูลตาราง Admin อาจารย์*/
SELECT am_id ,am_prefix, am_firstname,am_lastname,am_department_id,am_level,am_password
FROM admin_user
WHERE am_id = '';

/*แสดงใช้ตอน login*/
SELECT am_id,am_password
FROM admin_user
WHERE am_id = 'g';

/*
INSERT INTO admin_user (am_id,am_prefix,am_fristname,am_lastname,am_department_id,am_level,am_password)
VALUES (?,?,?,?,?,?,?);
*/

SELECT *
FROM admin_user
/*WHERE am_id = '002';*/

DELETE FROM admin_user WHERE am_id='abc';

/*นับ*/
SELECT COUNT(am_id)
FROM admin_user;

SELECT de_name
FROM department_table;

SELECT am_id,am_prefix,am_firstname,am_lastname,de_name,am_level,am_password
FROM admin_user

INNER JOIN department_table
ON admin_user.am_department_id = department_table.de_id;

INSERT INTO admin_user (am_id,am_prefix,am_firstname,am_lastname,am_department_id,am_level,am_password) 
VALUES ('464354',N'นาย',N'ตามี',N'มาดูตา',3,1,dbo.fncEncode('Papopporking2542'));
               
SELECT am_id,am_prefix,am_firstname,am_lastname,am_department_id,am_level, dbo.fncDecode(am_password) AS NewSalary
FROM admin_user ;

/* แสดงข้อมูล Admin */
SELECT am_id,am_prefix,am_firstname,am_lastname,de_name,am_level,dbo.fncDecode(am_password) AS Password , am_email
FROM admin_user
LEFT JOIN department_table
ON admin_user.am_department_id = department_table.de_id;

SELECT am_id,am_prefix,am_firstname,am_lastname,de_name,am_level,dbo.fncDecode(am_password) AS NewSalary
FROM admin_user
LEFT JOIN department_table
ON admin_user.am_department_id = department_table.de_id;


UPDATE admin_user 
SET am_id = '4646',am_prefix = N'อาจารย์',am_firstname = N'ตามี',am_lastname = N'มาหาตา',am_department_id = 4 ,am_level = 1,am_password = dbo.fncEncode('HHH') 
WHERE am_id = '4646';

/*
CREATE FUNCTION [dbo].[fncEncode]
(
	@sInput VARCHAR(1000)
)
RETURNS NVARCHAR(1000) 
AS
BEGIN
    RETURN EncryptByPassPhrase('sqlkeyadmin', @sInput);
END
*/

/*
CREATE FUNCTION [dbo].[fncDecode]
(
	@sInput NVARCHAR(1000)
)
RETURNS VARCHAR(1000) 
AS
BEGIN
    RETURN CONVERT(VARCHAR(100),DecryptByPassPhrase('sqlkeyadmin', @sInput));
END
*/

declare @decryptedValue nvarchar(4000)
declare @encryptedValue varbinary(8000)

SET @encryptedValue  = ENCRYPTBYPASSPHRASE('SQL SERVER 2008',N'SomeValue') --note the "N" before "N'SomeValue'"
Set @decryptedValue = DECRYPTBYPASSPHRASE('SQL SERVER 2008',@encryptedValue)

print @decryptedValue
