<?php
interface IDAO
{

    /**
     * Reads all entries from the database table associated with this DAO.
     *
     * @return an array of all Entity objects in the table
     * @throws SQLException on any exception arising from database access
     *                      errors
     */
    public function readDatabase(): array;

    /**
     * Inserts an entity to the database table associated with this DAO.
     *
     * @param e the entity to insert
     * @return the number of rows affected by the insert statement
     * @throws SQLException on any exception arising from database access
     *                      errors or non-unique primary key
     *                      constraints violated
     */
    public function insert($e): int;

    /**
     * Updates an existing entry in the database table associated with this DAO.
     *
     * @param e the entity to update
     * @return the number of rows affected by the update statement
     * @throws SQLException on any exception arising from database access
     *                      errors or identical primary key
     *                      constraints violated
     * 
     */
    public function update($e): int;

    /**
     * Deletes a given entity from the database table associated with this DAO.
     *
     * @param id the primary key of the entry to delete
     * @return the number of rows affected by the deletion statement
     * @throws SQLException on any exception arising from database access
     *                      errors
     * 
     */
    public function delete(int $id): int;

    /**
     * Searches the database table associated with this DAO for entities that match
     * the given condition
     * in the specified columns.
     *
     * @param condition   the search condition to use
     * @param columnNames the names of the columns to search in
     * @return a list of entities that match the search condition
     * @throws SQLException if there is any error accessing the database
     */
    public function search(string $condition, array $columnNames): array;
}
