<?php

namespace App\Http\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\User;

use JWTAuth;

class CreateUser
{
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $email     = $args["input"]["email"];
        $password  = $args["input"]["password"];

        $user = User::where(["email"=>$email])->get();

        if(count($user)) {
            return new \Exception("User exists!");
        }

        $u = new User;
        $u->email    = $email;
        $u->name = "joe";
        $u->password = \Hash::make($password);

        $s =  $u->save();

        $token = JWTAuth::fromUser($s);

        return $token;

    }
}
