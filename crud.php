--CRUD 

--create
INSERT INTO roles (name, value) VALUES ('Super' , 44)

--Read
SELECT id , name FROM roles ORDER BY name DESC LIMIT 3

--update 
UPDATE roles SET name='Editor' WHERE id=2

--delete
DELETE FROM roles WHERE id=2