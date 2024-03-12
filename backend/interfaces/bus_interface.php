<?php
interface IBUS
{
    /**
     * Returns a list of all models.
     *
     * @return array a list of all models
     */
    public function getAllModels(): array;

    /**
     * Refreshes the data in the model list.
     */
    public function refreshData(): void;

    /**
     * Returns the model with the given id.
     *
     * @param int $id the id of the model to retrieve
     * @return mixed the model with the given id, or null if not found
     */
    public function getModelById(int $id);

    /**
     * Adds the given model to the database.
     *
     * @param mixed $model the model to add
     * @return int the number of rows affected by the operation
     */
    public function addModel($model): int;

    /**
     * Updates the given model in the database.
     *
     * @param mixed $model the model to update
     * @return int the number of rows affected by the operation
     */
    public function updateModel($model): int;

    /**
     * Deletes the model with the given id from the database.
     *
     * @param int $id the id of the model to delete
     * @return int the number of rows affected by the operation
     */
    public function deleteModel(int $id): int;

    /**
     * Searches for models that match the given value in the specified columns.
     *
     * @param string $value the value to search for
     * @param array $columns the columns to search in
     * @return array a list of models that match the search criteria
     */
    public function searchModel(string $value, array $columns): array;
}
