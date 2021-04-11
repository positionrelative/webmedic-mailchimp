<?php

namespace App\Console\Commands;

use App\MailchimpManager;
use App\Models\EmailSubscription;
use Illuminate\Console\Command;

class SyncSubscribersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:subscribers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(MailchimpManager $manager)
    {
        EmailSubscription::where('status', '!=', 'pending')->delete();
        if ($manager->getListMembers()->total_items) {
            foreach ($manager->getListMembers()->members as $member) {
                $model = EmailSubscription::where('email', $member->email_address)->first();

                if ( ! $model) {
                    $model = new EmailSubscription();
                    $model->email = $member->email_address;
                }

                $model->status = $member->status;
                $model->hash   = $member->id;

                $model->save();
            }
        }

        $pendingEmails = EmailSubscription::where('status', 'pending')->get();

        if($pendingEmails) {
            foreach ($pendingEmails as $row) {
                $manager->subscribe($row->email);
                $row->status = 'subscribed';
                $row->save();
            }
        }
    }
}
