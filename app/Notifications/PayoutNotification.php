<?php

namespace App\Notifications;

use App\Models\Scopes\WorkScope;
use App\Models\Work;
use Carbon\Carbon;
use Cknow\Money\Money;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;

class PayoutNotification extends Notification
{
    use Queueable;

    public $work;

    public function __construct(Work $work)
    {
        $this->work = $work;
    }

    public function via($notifiable): array
    {
        return [AfricasTalkingChannel::class];
    }

    public function toAfricasTalking($notifiable)
    {
        $payout = Work::withoutGlobalScope(WorkScope::class)->where('employee_id', '=', $this->work->employee_id)->sum('payout');

        return (new AfricasTalkingMessage())
            ->content('Turabasuhuje '.$this->work->employee->names.'!'.' Uno munsi'
            . Carbon::parse($this->work->created_at)->toDateString().' Mwakoreye amafaranga '.Money::RWF( $payout).' Ubuyobozi bwa ZAGNUT CLUB.')
            ->to($this->work->employee->phone_number);
    }
}
