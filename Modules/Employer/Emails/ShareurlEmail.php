<?php

namespace Modules\Employer\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;


class ShareurlEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($share_url)
    {
        //

        $this->share_url = $share_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $employer_email = Auth::user()->email;
        $employer_companyname = Auth::user()->company_name;
        return $this->from($employer_email,$employer_companyname)->view('employer::sendmail.shareurl') ->with([
                        'data' => $this->share_url
                    ]);
    }
}
