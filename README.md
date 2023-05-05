# example
docker-compose up -d 

docker exec -i example-db-1 mysql -u root -pmy_root_password my_db < ./app/src/migrations/1_create_user.sql

docker exec -i example-db-1 mysql -u root -pmy_root_password my_db < ./app/src/migrations/2_add_user.sql


GET http://localhost:82/users
