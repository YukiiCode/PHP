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

    public function update(User $user, Cuotas $cuota)
    {
        return $cuota->empleado_id === $user->id;
    }
}