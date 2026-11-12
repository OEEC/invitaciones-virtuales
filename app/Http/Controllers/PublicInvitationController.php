<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class PublicInvitationController extends Controller
{
    public function show(string $slug, ?string $token = null)
    {
        $invitation = Invitation::with('template')->where('slug', $slug)->firstOrFail();
        abort_unless($invitation->status === 'published' || auth()->check(), 404);

        $guest = $token ? $invitation->guests()->where('token', $token)->firstOrFail() : null;

        return view($invitation->template->view, [
            'invitation' => $invitation,
            'd' => array_merge(
                config("invitation_defaults.{$invitation->template->slug}", []),
                array_filter($invitation->data ?? [], fn ($v) => $v !== null && $v !== '')
            ),
            'guest' => $guest,
        ]);
    }

    public function rsvp(Request $request, string $slug, string $token)
    {
        $invitation = Invitation::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $guest = $invitation->guests()->where('token', $token)->firstOrFail();

        $data = $request->validate([
            'rsvp' => 'required|in:yes,no',
            'companions' => 'nullable|integer|min:0',
            'message' => 'nullable|string|max:500',
        ]);

        $guest->update([
            'rsvp' => $data['rsvp'],
            'companions' => $data['rsvp'] === 'yes' ? min((int) ($data['companions'] ?? 0), $guest->max_companions) : 0,
            'message' => $data['message'] ?? null,
            'responded_at' => now(),
        ]);

        return redirect(route('invitation.show', [$slug, $token]).'#confirmacion')->with('rsvp_ok', true);
    }
}