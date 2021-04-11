<?php


namespace App;


use Illuminate\Support\Facades\Log;

class MailchimpManager
{
    private $mailChimp;
    private $listId;

    public function __construct($mailChimp, $listId)
    {
        $this->mailChimp = $mailChimp;
        $this->listId    = $listId;
    }

    public function subscribe($email)
    {
        try {
            $response = $this->getMailchimp()->lists->setListMember($this->getListId(), md5($email), [
                "email_address" => $email,
                "status"        => "subscribed",
            ]);

            Log::info('subscribe setListMember response:'.print_r($response, true));

            return $response->id;
        } catch (\Exception $e) {
            Log::error("Can't subscribe user with email: {$email} {$e->getMessage()}");
        }
    }

    public function unsubscribe($hash)
    {
        try {
            $response = $this->getMailChimp()->lists->setListMember($this->getListId(), $hash, [
                "status" => "unsubscribed",
            ]);

            Log::info('unsubscribe setListMember response:'.print_r($response, true));

            return $response->id;
        } catch (\Exception $e) {
            Log::error("Can't unsubscribe user with hash: {$hash} {$e->getMessage()}");
        }
    }

    public function delete($hash)
    {
        try {
            $response = $this->getMailchimp()->lists->deleteListMemberPermanent(
                $this->getListId(),
                $hash
            );

            Log::info('delete deleteListMemberPermanent response:'.print_r($response, true));
            return true;
        } catch (\Exception $e) {
            Log::error("Can't delete user with hash: {$hash} {$e->getMessage()}");

            return false;
        }
    }

    public function getListMembers()
    {
        try {
            $response = $this->getMailChimp()->lists->getListMembersInfo($this->getListId());

            Log::info('getListMembersInfo response:'.print_r($response, true));

            return $response;
        } catch (\Exception $e) {
            Log::error("Can't receive list member informations: {$e->getMessage()}");

            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getMailChimp()
    {
        return $this->mailChimp;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

}
