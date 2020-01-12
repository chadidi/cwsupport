<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AuthMutator
{
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = User::where('email', $args['email'])->first();

        if (!$user) {
            return null;
        }

        if (!Hash::check($args['password'], $user->password)) {
            return null;
        }

        $token = Str::random(60);
        $user->api_token = $token;
        $user->save();

        return [
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => $user,
        ];
    }

    public function register($rootValue, array $args, GraphQLContext $context)
    {
        $token = Str::random(60);

        $user = new User($args);
        $user->api_token = $token;
        $user->save();

        return [
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => $user,
        ];
    }

    public function logout($rootValue, array $args, GraphQLContext $context)
    {
        $user = auth()->user();
        $user->api_token = null;
        $user->save();

        return [
            'status'  => 'success',
            'message' => 'Logged out seccessfully!',
        ];
    }
}
