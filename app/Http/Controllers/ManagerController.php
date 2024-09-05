<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\PersonModel;
use App\Models\AddressModel;
use App\Models\NoteModel;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Collects all the data to load the overview page
     *
     * @return View
     */
    function overview (): View
    {
        // Get all
        $dataArray = [];

        return view('overview', $dataArray);
    }

    /**
     * Creates a new person
     *
     * @param Request $request
     *
     * @return void
     */
    function createPerson (Request $request): void
    {
        // Create a new person in the database
        $person = PersonModel::create([
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
        ]);

        // Create the addresses
        if ($request->addresses && $request->addresses['city']) {
            $this->createAddress($request->addresses, $person['id']);

        } else if ($request->addresses) {
            foreach ($request->addresses as $address) {
                $this->createAddress($address, $person['id']);
            }
        }

        // Create the notes
        if ($request->notes && $request->notes['note']) {
            $this->createNote($request->notes, 'person', $person['id']);

        } else if ($request->notes) {
            foreach ($request->notes as $note) {
                $this->createNote($note, 'person', $person['id']);
            }
        }
    }

    /**
     * Updates an existing person
     *
     * @param Request $request
     *
     * @return void
     */
    function updatePerson (Request $request): void
    {
        // Update a person in the database
        $person = PersonModel::find($request->id)->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
        ]);

        // Update the addresses
        if ($request->addresses && $request->addresses['city']) {
            $this->updateAddress($request->addresses, $person['id']);

        } else if ($request->addresses) {
            foreach ($request->addresses as $address) {
                $this->updateAddress($address, $person['id']);
            }
        }

        // Update the notes
        if ($request->notes && $request->notes['note']) {
            $this->updateNote($request->notes, 'person', $person['id']);

        } else if ($request->notes) {
            foreach ($request->notes as $note) {
                $this->updateNote($note, 'person', $person['id']);
            }
        }
    }

    /**
     * Deletes a person
     *
     * @param Request $request
     *
     * @return void
     */
    function deletePerson (Request $request): void
    {
        // Delete a person from the database
        PersonModel::find($request->id)->delete();
    }

    /**
     * Creates a new address
     *
     * @param array $address
     * @param int $person_id
     *
     * @return void
     */
    function createAddress (array $address, int $person_id): void
    {
        // Save notes to prevent them being overwritten
        $notes = $address['notes'];

        // Create a new address in the database
        $address = AddressModel::create([
            'person_id' => $person_id,
            'street_name' => $address['street_name'],
            'street_number' => $address['street_number'],
            'city' => $address['city'],
        ]);

        // Create the notes
        if ($notes && $notes['note']) {
            $this->updateNote($notes, 'address', $address['id']);

        } else if ($notes) {
            foreach ($notes as $note) {
                $this->updateNote($note, 'address', $address['id']);
            }
        }
    }

    /**
     * Updates an existing address
     *
     * @param array $address
     * @param int $person_id
     *
     * @return void
     */
    function updateAddress (array $address, int $person_id): void
    {
        // Save notes to prevent them being overwritten
        $notes = $address['notes'];

        // Update an address if it already exists in the database, otherwise create a new address
        $addressExists = AddressModel::find($address['id']);

        if ($addressExists) {
            $addressExists->update([
                'street_name' => $address['street_name'],
                'street_number' => $address['street_number'],
                'city' => $address['city'],
            ]);
        } else {
            AddressModel::create([
                'person_id' => $person_id,
                'street_name' => $address['street_name'],
                'street_number' => $address['street_number'],
                'city' => $address['city'],
            ]);
        }

        // Update the notes
        if ($notes && $notes['note']) {
            $this->updateNote($notes, 'address', $address['id']);

        } else if ($notes) {
            foreach ($notes as $note) {
                $this->updateNote($note, 'address', $address['id']);
            }
        }
    }

    /**
     * Deletes an address
     *
     * @param Request $request
     *
     * @return void
     */
    function deleteAddress (Request $request): void
    {
        // Delete an address from the database
        AddressModel::find($request->id)->delete();
    }

    /**
     * Creates a new note
     *
     * @param array $note
     * @param string $type
     * @param int $related_id
     *
     * @return void
     */
    function createNote (array $note, string $type, int $related_id): void
    {
        // Create a new note in the database
        NoteModel::create([
            'related_id' => $related_id,
            'type' => $type,
            'note' => $note['note'],
        ]);
    }


    /**
     * Creates a new note
     *
     * @param array $note
     * @param string $type
     * @param int $related_id
     *
     * @return void
     */
    function updateNote (array $note, string $type, int $related_id): void
    {
        // Update a note if it already exists in the database, otherwise create a new note
        $noteExists = NoteModel::find($note['id']);

        if ($noteExists) {
            $noteExists->update([
                'note' => $note['note']
            ]);
        } else {
            NoteModel::create([
                '$related_id' => $related_id,
                'type' => $type,
                'note' => $note['note'],
            ]);
        }
    }


    /**
     * Deletes a note
     *
     * @param Request $request
     *
     * @return void
     */
    function deleteAddress (Request $request): void
    {
        // Delete a note from the database
        AddressModel::find($request->id)->delete();
    }
}
