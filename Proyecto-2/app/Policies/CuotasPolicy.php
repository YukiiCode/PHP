namespace App\Policies;

use App\Models\User;
use App\Models\Cuotas;
use Illuminate\Auth\Access\Response;

class CuotasPolicy
{
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }
    }
}