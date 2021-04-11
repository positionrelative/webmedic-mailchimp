<?php

namespace App\Http\Controllers;

use App\Http\Newsletter\SubscriptionManager;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\EmailSubscription;
use App\MailchimpManager;
use Illuminate\Http\Request;
use MailchimpTransactional\ApiClient;

class ManageSubscribersController extends Controller
{
    public function index() {
        $data = EmailSubscription::paginate(50);

        return view('manage-subscribers/index', [
            'data' => $data
        ]);
    }

    public function create() {
        $model = new EmailSubscription();

        return view('manage-subscribers/form', [
            'model' => $model
        ]);
    }

    public function store(StoreSubscriptionRequest $request) {
        $request->store();

        return redirect('/')->with('success', 'Sikeresen rögzítve!');
    }

    public function unsubscribe($id) {
        $model = EmailSubscription::find($id);

        if($model) {
            $remove = app('mailchimpmanager')->unsubscribe($model->hash);

            if($remove) {
                $model->status = "unsubscribed";
                $model->save();

                return redirect(route('subscriber.index'))->with('success', 'Sikeres leiratkoztatás!');
            } else {
                return redirect(route('subscriber.index'))->with('error', 'Hiba történt a leiratkoztatás során!');
            }

        } else {
            return redirect(route('subscriber.index'))->with('error', 'A rekord nem található!');
        }
    }

    public function delete($id) {

        $model = EmailSubscription::find($id);

        if($model) {
            $remove = app('mailchimpmanager')->delete($model->hash);

            if($remove) {
                $model->delete();

                return redirect(route('subscriber.index'))->with('success', 'Sikeres törlés!');
            } else {
                return redirect(route('subscriber.index'))->with('error', 'Hiba történt a törlés során!');
            }

        } else {
            return redirect(route('subscriber.index'))->with('error', 'A rekord nem található!');
        }

    }
}
