<?php

namespace OfflineAgency\LaravelFattureInCloudV2\Entities\User;

class UserList
{
    private $items;
    private $pagination;

    public function __construct($user_response)
    {
        $this->setItems($user_response);
        $this->setPagination($user_response);
    }

    /**
     * @return array<User>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return UserPagination
     */
    public function getPagination(): USerPagination
    {
        return $this->pagination;
    }

    private function setItems(
        $user_response
    ): void {
        $this->items = array_map(function ($user) {
            return new User($user);
        }, $user_response->data);
    }

    private function setPagination(
        $user_response
    ): void {
        $this->pagination = new UserPagination($user_response);
    }
}
