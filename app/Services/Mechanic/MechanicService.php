<?php

namespace App\Services\Mechanic;

use App\Models\Mechanic;
use Illuminate\Http\UploadedFile;
use App\Actions\UploadImageAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Notifications\WelcomeMechanicNotification;
use App\Interfaces\Mechanic\MechanicServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MechanicService implements MechanicServiceInterface
{
    protected $uploadImageAction;

    public function __construct(UploadImageAction $uploadImageAction)
    {
        $this->uploadImageAction = $uploadImageAction;
    }

    /**
     * Store mechanic details and handle image upload within a transaction.

     * @param array $data
     * @param \Illuminate\Http\UploadedFile|null $file
     * @param \App\Actions\UploadImageAction $uploadImageAction
     * @return \App\Models\Mechanic
     */
    public function storeMechanicDetails(array $data, ?UploadedFile $file): Mechanic
    {
        return DB::transaction(function () use ($data, $file) {
            // Store mechanic data
            $mechanic = Mechanic::create($data);
            // Handle image upload if a file is provided
            if ($file) {
                // Call the UploadImageAction to handle the image processing
                $this->uploadImageAction->execute($mechanic, $file);
            }

            // Send welcome email notification
            $mechanic->notify(new WelcomeMechanicNotification($mechanic));

            return $mechanic;
        });
    }


    public function getMechanics(): LengthAwarePaginator
    {
        return Mechanic::paginate(10);
    }

    public function getMechanic(string $id): Mechanic
    {
        $mechanic = Mechanic::whereUuid($id)->first();

        if (!$mechanic) {
            throw new NotFoundHttpException(__('app.resource_not_found'));
        }

        return $mechanic;
    }

    public function deleteMechanic(string $id): bool
    {
        $mechanic = $this->getMechanic($id);


        return $mechanic->delete();
    }
    public function updateMechanic(array $data, string $id, ?UploadedFile $file): Mechanic
    {

        $mechanic = $this->getMechanic($id);

        return DB::transaction(function () use ($data, $file, $mechanic) {
            $mechanic->update($data);
            // Handle image upload if a file is provided
            if ($file) {
                // Call the UploadImageAction to handle the image processing
                $this->uploadImageAction->execute($mechanic, $file, true);
            }




            return $mechanic;
        });
    }
}
