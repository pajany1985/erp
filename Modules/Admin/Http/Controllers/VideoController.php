<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;



class VideoController extends Controller
{
    public function saveStream(Request $request)
    {
        // Assuming the video stream is sent as base64 encoded data in the request body
        $videoData = $request->input('videoData');

        // Decode the base64 encoded video data
        $decodedData = base64_decode($videoData);

        // Append the video data to the video file
       // Storage::disk('local')->append('video_stream.webm', $decodedData);
        Storage::disk('local')->append('videos/video_stream.webm', $decodedData);

        return response()->json(['message' => 'Video stream saved successfully']);
    }
}

?>