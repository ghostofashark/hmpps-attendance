<?php
namespace App\Providers;
use App\Models\AbsenceRecord;
use App\Models\AuthorisedViewer;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {}
    public function boot(): void {
        Gate::define('view-any-absence', function (User $user) {
            if ($user->hasRole(['hobba','governor'])) return true;
            return AuthorisedViewer::isAuthorised($user->email);
        });
        Gate::define('view-absence', function (User $user, AbsenceRecord $absence) {
            if (Gate::forUser($user)->allows('view-any-absence')) return true;
            return $absence->staff->line_manager_id === $user->id
                || $absence->staff->hobba_id === $user->id;
        });
    }
}
