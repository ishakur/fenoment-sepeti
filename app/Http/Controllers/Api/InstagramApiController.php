<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstagramApiController extends ApiController
{
    private string $url    = 'https://i.instagram.com/api/v1/users/web_profile_info/?username=';
    private array  $header = [
        "accept"          => "*/*",
        "accept-language" => "tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7,ru;q=0.6",
        "x-asbd-id"       => "198387",
        "x-csrftoken"     => "kghihXYqfUCqjWJWkXTrIesNHJj76x5z",
        "x-ig-app-id"     => "936619743392459",
    ];

    /**
     * Display the specified resource.
     *
     * @param string $username
     *
     */
    public function show($username)
    {
        $url      = $this->url . $username;
        $response = Http::withHeaders($this->header)->get($url);

        if ($response->successful()) {

            $jsonResponse = json_decode($response);
            $user         = $jsonResponse->data->user;
            $isPrivate    = $user->is_private;
            $isVerified   = $user->is_verified;
            if (!$isPrivate) {
                $followerCount       = $user->edge_followed_by->count;
                $followingCount      = $user->edge_follow->count;
                $mediaNodes          = $user->edge_owner_to_timeline_media->edges;
                $reelsNodes          = $user->edge_felix_video_timeline->edges;
                $sumMediaCount       = $user->edge_owner_to_timeline_media->count;
                $userFullName        = $user->full_name;
                $userProfileCategory = $user->category_name;
                $mediaNodeCount      = count($mediaNodes);
                $mediaCount          = $user->edge_owner_to_timeline_media->count;
                $reelsNodeCount      = $user->edge_felix_video_timeline->count;

                $avarageprops = self::averageCalculation($mediaNodes, $reelsNodes, $sumMediaCount, $mediaNodeCount);
                //dd($avarageprops);

                $avarageLikeCount      = $avarageprops['avarageLikeCount'];
                $avarageViewCountReels = $avarageprops['avarageViewCountReels'];
                $avarageCommandCount   = $avarageprops['avarageCommandCount'];


                $userDetail = [
                    'userFullName'          => $userFullName,
                    'userProfileCategory'   => $userProfileCategory,
                    'isPrivate'             => $isPrivate,
                    'isVerified'            => $isVerified,
                    'followerCount'         => $followerCount,
                    'followingCount'        => $followingCount,
                    'avarageLikeCount'      => $avarageLikeCount,
                    'avarageViewCountReels' => $avarageViewCountReels,
                    'sumMediaCount'         => $sumMediaCount,
                    'avarageCommandCount'   => $avarageCommandCount,
                    'mediaCount'            => $mediaCount,

                ];
                return $userDetail;

            } else {
                throw new Exception("Influencer's account is private! Please change your account to public and try again.", 409);
            }
        } else {
            throw new Exception ('User not found! Check your platform username and try again.');
        }

    }

    private function averageCalculation($mediaNodes, $reelsNodes, $mediaNodeCount, $reelsNodeCount)
    {
        $sumLikeCountAllMedia = 0;
        $sumViewCountReels    = 0;
        $sumCommandCount      = 0;

        foreach ($mediaNodes as $n) {
            $sumLikeCountAllMedia += (int)$n->node->edge_liked_by->count;
            $sumCommandCount      += (int)$n->node->edge_media_to_comment->count;
        }
        // dd($sumCommandCount);
        foreach ($reelsNodes as $n) {

            $sumViewCountReels += (int)$n->node->video_view_count;
        }
        $avarageLikeCount      = (int)($sumLikeCountAllMedia / $mediaNodeCount);
        $avarageViewCountReels = (int)($sumViewCountReels / $reelsNodeCount);
        $avarageCommandCount   = (int)($sumCommandCount / $mediaNodeCount);
        $avarageProps          = [
            'avarageLikeCount'      => $avarageLikeCount,
            'avarageViewCountReels' => $avarageViewCountReels,
            'avarageCommandCount'   => $avarageCommandCount,
        ];
        return $avarageProps;
    }
}
