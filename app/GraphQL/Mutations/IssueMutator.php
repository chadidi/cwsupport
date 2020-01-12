<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Models\Issue;
use App\Notifications\IssueClosed;
use App\Notifications\IssueSubmitted;
use App\Notifications\IssueStatusChanged;
use Illuminate\Support\Facades\Notification;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class IssueMutator
{
    public function submit($rootValue, array $args, GraphQLContext $context)
    {
        $user = $context->user();
        $issue = new Issue($args);
        $issue->status = 'SUBMITTED';
        $user->issues()->save($issue);

        $user->notify(new IssueSubmitted($issue));

        return $issue;
    }

    public function update($rootValue, array $args, GraphQLContext $context)
    {
        $issue = Issue::find($args['id']);
        $oldStatus = $issue->status;
        $issue->title = $args['title'];
        $issue->description = $args['description'];
        $issue->status = $args['status'];
        $issue->tags = $args['tags'];
        $issue->save();

        if ($oldStatus != $args['status']) {
            $issue->user->notify(new IssueStatusChanged($issue));
        }

        return $issue;
    }

    public function close($rootValue, array $args, GraphQLContext $context)
    {
        $issue = Issue::find($args['id']);
        $issue->status = 'CLOSED';
        $issue->save();

        $admins = User::where('is_admin', true)->get();

        Notification::send($admins, new IssueClosed($issue));

        return $issue;
    }
}
