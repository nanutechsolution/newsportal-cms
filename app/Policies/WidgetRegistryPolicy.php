<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\WidgetRegistry;
use Illuminate\Auth\Access\HandlesAuthorization;

class WidgetRegistryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:WidgetRegistry');
    }

    public function view(AuthUser $authUser, WidgetRegistry $widgetRegistry): bool
    {
        return $authUser->can('View:WidgetRegistry');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:WidgetRegistry');
    }

    public function update(AuthUser $authUser, WidgetRegistry $widgetRegistry): bool
    {
        return $authUser->can('Update:WidgetRegistry');
    }

    public function delete(AuthUser $authUser, WidgetRegistry $widgetRegistry): bool
    {
        return $authUser->can('Delete:WidgetRegistry');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:WidgetRegistry');
    }

    public function restore(AuthUser $authUser, WidgetRegistry $widgetRegistry): bool
    {
        return $authUser->can('Restore:WidgetRegistry');
    }

    public function forceDelete(AuthUser $authUser, WidgetRegistry $widgetRegistry): bool
    {
        return $authUser->can('ForceDelete:WidgetRegistry');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:WidgetRegistry');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:WidgetRegistry');
    }

    public function replicate(AuthUser $authUser, WidgetRegistry $widgetRegistry): bool
    {
        return $authUser->can('Replicate:WidgetRegistry');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:WidgetRegistry');
    }

}