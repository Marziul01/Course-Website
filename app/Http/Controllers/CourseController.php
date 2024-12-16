<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use App\Services\VideoEncryptionService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public static function index(){
        return view('admin.course.course',[
            'courses' => Course::where('combo', 0)->get(),
        ]);
    }

    public static function add(){
        return view('admin.course.add',[
            'categories' =>  Category::where('status',1)->get(),
        ]);
    }

    public static function edit($id){
        return view('admin.course.edit',[
            'course' => Course::find($id),
            'categories' =>  Category::where('status',1)->get(),
        ]);
    }

    public static function courseDelete(Request $request, $id){
        $courseDelete = Course::find($id);
        $courseDelete->delete();
        return back();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi,flv',
            'category_id' => 'nullable|exists:categories,id',
            'sale_price' => 'nullable|integer',
            'price' => 'required|integer',
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'tags' => 'nullable|string',
            'status' => 'nullable|boolean',
            'modules' => 'array',
            'modules.*.name' => 'required|string|max:255',
            'modules.*.desc' => 'nullable|string',
            'modules.*.video' => 'nullable|mimes:mp4,mov,avi,flv',
            'modules.*.pdf' => 'nullable|array',
            'modules.*.pdf.*' => 'nullable|mimes:pdf',
        ]);

        // Custom validation for module videos
        foreach ($request->modules as $moduleIndex => $moduleData) {
            if ($request->hasFile("modules.$moduleIndex.video")) {
                $video = $request->file("modules.$moduleIndex.video");
                $videoPath = $video->getRealPath();

                // Use FFmpeg to check video dimensions
                $ffprobe = \FFMpeg\FFProbe::create();
                $videoDimensions = $ffprobe->streams($videoPath)
                    ->videos()
                    ->first()
                    ->getDimensions();

                $width = $videoDimensions->getWidth();
                $height = $videoDimensions->getHeight();

                // Check for portrait video
                if ($height > $width) {
                    $validator->after(function ($validator) use ($moduleIndex) {
                        $validator->errors()->add("modules.$moduleIndex.video", 'Portrait videos are not allowed. Please upload a landscape video.');
                    });
                }

                // Check if dimensions exceed 1080x720
                if ($width > 1080 || $height > 720) {
                    $validator->after(function ($validator) use ($moduleIndex) {
                        $validator->errors()->add("modules.$moduleIndex.video", 'Video width must not exceed 1080px and height must not exceed 720px.');
                    });
                }
            }
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Save Course
        $course = new Course();
        $course->category_id = $request->input('category_id');
        $course->sale_price = $request->input('sale_price');
        $course->price = $request->input('price');
        $course->title = $request->input('title');
        $course->desc = $request->input('desc');
        $course->tags = $request->input('tags');
        $course->status = $request->input('status', 1); // Default status
        
        $banglaString = $request->input('title');
        $englishSlug = Str::slug($banglaString);
        
        $course->slug = $englishSlug;

        // Handle Course Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $englishSlug . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('admin-assets/courses/images/'), $imageName);
            $course->image = 'admin-assets/courses/images/' . $imageName;
        }

        // Handle Course Video Upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = $request->input('title') . '_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('admin-assets/courses/videos/'), $videoName);
            $course->video = 'admin-assets/courses/videos/' . $videoName;
        }

        // Save the course
        $course->save();

        // Handle Modules
        if ($request->has('modules')) {
            foreach ($request->input('modules') as $moduleIndex => $moduleData) {
                $module = new Module();
                $module->course_id = $course->id;
                $module->name = $moduleData['name'];
                $module->desc = $moduleData['desc'];
                
                $banglaModuleString = $moduleData['name'];
                $englishModuleSlug = Str::slug($banglaModuleString); 


                // Handle Module Video Upload
                if ($request->hasFile("modules.$moduleIndex.video")) {
                    $moduleVideo = $request->file("modules.$moduleIndex.video");
                    $moduleVideoName = $englishModuleSlug .time() . '.' . $moduleVideo->getClientOriginalExtension();

                    // Move the uploaded video to a temporary location first
                    $moduleVideo->move(public_path('admin-assets/courses/modules/videos/'), $moduleVideoName);

                    // Define paths for encryption
                    $inputVideoPath = "admin-assets/courses/modules/videos/{$moduleVideoName}";
                    $encryptedVideoPath = "admin-assets/courses/modules/videos/encrypted_{$moduleVideoName}/adaptive.m3u8";
                    $encryptedVideoKeyPath = "admin-assets/courses/modules/videos/encrypted_{$moduleVideoName}/";
                    // Encrypt and save the video using the service
                    VideoEncryptionService::encryptAndSave($moduleVideoName, $encryptedVideoPath, $encryptedVideoKeyPath);

                    // Store the encrypted video path in the module
                    $module->video = $encryptedVideoPath;
                }

                // Handle Module PDF Uploads
                if ($request->has("modules.$moduleIndex.pdf")) {
                    $pdfFiles = $request->file("modules.$moduleIndex.pdf");
                    $pdfPaths = [];

                    foreach ($pdfFiles as $pdfFile) {
                        if ($pdfFile) {
                            $pdfName = $englishModuleSlug . '_' . uniqid() . '.' . $pdfFile->getClientOriginalExtension();
                            $pdfFile->move(public_path('admin-assets/courses/modules/pdfs/'), $pdfName);
                            $pdfPaths[] = 'admin-assets/courses/modules/pdfs/' . $pdfName;
                        }
                    }

                    // Store the PDF paths as a JSON string (or as a separate table if needed)
                    $module->pdf = json_encode($pdfPaths); // Store as JSON
                }

                // Save Module
                $module->save();
            }
        }

        return response()->json(['message' => 'Course and modules saved successfully!'], 200);
    }





//     public function store(Request $request)
// {
//     $request->validate([
//         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         'video' => 'nullable|mimes:mp4,mov,avi,flv|max:50000', // Validate video if it's uploaded
//         'category_id' => 'nullable|exists:categories,id',
//         'sale_price' => 'nullable|integer',
//         'price' => 'nullable|integer',
//         'title' => 'required|string|max:255',
//         'desc' => 'nullable|string',
//         'tags' => 'nullable|string',
//         'status' => 'nullable|boolean',
//         'modules' => 'array',
//         'modules.*.name' => 'required|string|max:255',
//         'modules.*.desc' => 'nullable|string',
//         'modules.*.video' => 'nullable|mimes:mp4,mov,avi,flv|max:50000',
//         'modules.*.pdf' => 'nullable|mimes:pdf|max:10000',
//     ]);

//     // Save Course
//     $course = new Course();
//     $course->category_id = $request->input('category_id');
//     $course->sale_price = $request->input('sale_price');
//     $course->price = $request->input('price');
//     $course->title = $request->input('title');
//     $course->desc = $request->input('desc');
//     $course->tags = $request->input('tags');
//     $course->status = $request->input('status', 1); // Default status

//     // Handle Course Image Upload
//     if ($request->hasFile('image')) {
//         $image = $request->file('image');
//         $imageName = $request->input('title') . '_' . time() . '.' . $image->getClientOriginalExtension();
//         $image->move(public_path('admin-assets/courses/images/'), $imageName);
//         $course->image = 'admin-assets/courses/images/' . $imageName;
//     }

//     // Handle Course Video Upload
//     if ($request->hasFile('video')) {
//         $video = $request->file('video');
//         $videoName = $request->input('title') . '_' . time() . '.' . $video->getClientOriginalExtension();
//         $video->move(public_path('admin-assets/courses/videos/'), $videoName);
//         $course->video = 'admin-assets/courses/videos/' . $videoName;
//     }

//     // Save the course
//     $course->save();

//     // Handle Modules
//     if ($request->has('modules')) {
//         foreach ($request->input('modules') as $moduleIndex => $moduleData) {
//             $module = new Module();
//             $module->course_id = $course->id;
//             $module->name = $moduleData['name'];
//             $module->desc = $moduleData['desc'];

//             // Handle Module Video Upload
//             if ($request->hasFile("modules.$moduleIndex.video")) {
//                 $moduleVideo = $request->file("modules.$moduleIndex.video");
//                 $moduleVideoName = $moduleData['name'] . '_' . time() . '.' . $moduleVideo->getClientOriginalExtension();
//                 $moduleVideo->move(public_path('admin-assets/courses/modules/videos/'), $moduleVideoName);
//                 $module->video = 'admin-assets/courses/modules/videos/' . $moduleVideoName;
//             }

//             // Handle Module PDF Upload
//             if ($request->hasFile("modules.$moduleIndex.pdf")) {
//                 $modulePdf = $request->file("modules.$moduleIndex.pdf");
//                 $modulePdfName = $moduleData['name'] . '_' . time() . '.' . $modulePdf->getClientOriginalExtension();
//                 $modulePdf->move(public_path('admin-assets/courses/modules/pdfs/'), $modulePdfName);
//                 $module->pdf = 'admin-assets/courses/modules/pdfs/' . $modulePdfName;
//             }

//             // Save Module
//             $module->save();
//         }
//     }

//     return redirect()->route('admin.course')->with('success', 'Course and modules saved successfully!');
// }

public function courseUpdate(Request $request, $courseId)
{
    $course = Course::find($courseId);

    // Update basic course details
    $course->title = $request->input('title');
    $course->category_id = $request->input('category_id');
    $course->desc = $request->input('desc');
    $course->sale_price = $request->input('sale_price');
    $course->price = $request->input('price');
    $course->tags = $request->input('tags');
    
    $banglaString = $request->input('title');
        $englishSlug = Str::slug($banglaString);
        
        $course->slug = $englishSlug;

    // Handle Course Image Upload
    if ($request->hasFile('image')) {
        if ($course->image && file_exists(public_path($course->image))) {
            unlink(public_path($course->image));
        }

        $image = $request->file('image');
        $imageName = $englishSlug . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('admin-assets/courses/images/'), $imageName);
        $course->image = 'admin-assets/courses/images/' . $imageName;
    }

    // Handle Course Video Upload
    if ($request->hasFile('video')) {
        if ($course->video && file_exists(public_path($course->video))) {
            unlink(public_path($course->video));
        }

        $video = $request->file('video');
        $videoName = $request->input('title') . '_' . time() . '.' . $video->getClientOriginalExtension();
        $video->move(public_path('admin-assets/courses/videos/'), $videoName);
        $course->video = 'admin-assets/courses/videos/' . $videoName;
    }


    $modulesData = $request->input('premodules'); // Get the submitted modules data

foreach ($modulesData as $index => $moduleData) {
    $module = Module::findOrFail($moduleData['id']); // Find the module by its ID

    // Update the module name and description
    $module->name = $moduleData['name'] ?? $module->name;
    $module->desc = $moduleData['desc'] ?? $module->desc;
    
    $banglapreModuleString = $moduleData['name'];
    $englishpreModuleSlug = Str::slug($banglapreModuleString); 

    // Handle Module Video Upload
    if ($request->hasFile("premodules.$index.video")) {
        $video = $request->file("premodules.$index.video");

        // Delete the previous video if it exists
        if ($module->video && File::exists(public_path($module->video))) {
            File::delete(public_path($module->video));
        }

        // Save the new video
        $videoName = $moduleData['name'] . '_' . time() . '.' . $video->getClientOriginalExtension();
        $video->move(public_path('admin-assets/courses/modules/videos/'), $videoName);
        $module->video = 'admin-assets/courses/modules/videos/' . $videoName;
    }

    // Handle Module PDF Upload
    if ($request->hasFile("premodules.$index.pdfs")) {
        // Delete previous PDFs if they exist
        if ($module->pdf) {
            foreach (explode(',', $module->pdf) as $pdf) {
                if (File::exists(public_path($pdf))) {
                    File::delete(public_path($pdf));
                }
            }
        }

        // Save the new PDFs
        $pdfFiles = $request->file("premodules.$index.pdfs");
        $pdfPaths = [];

        foreach ($pdfFiles as $pdfFile) {
            if ($pdfFile) {
                $pdfName = $englishpreModuleSlug . '_' . uniqid() . '.' . $pdfFile->getClientOriginalExtension();
                $pdfFile->move(public_path('admin-assets/courses/modules/pdfs/'), $pdfName);
                $pdfPaths[] = 'admin-assets/courses/modules/pdfs/' . $pdfName;
            }
        }

        // Store the PDF paths as a comma-separated string
        $module->pdf = json_encode($pdfPaths);
    }

    // Save the module updates
    $module->save();
}




    if ($request->has('modules')) {
        foreach ($request->input('modules') as $moduleIndex => $moduleData) {
            $module = new Module();
            $module->course_id = $course->id;
            $module->name = $moduleData['name'];
            $module->desc = $moduleData['desc'];
            
            $banglaModuleString = $moduleData['name'];
            $englishModuleSlug = Str::slug($banglaModuleString); 

            // Handle Module Video Upload
            if ($request->hasFile("modules.$moduleIndex.video")) {
                $moduleVideo = $request->file("modules.$moduleIndex.video");
                $moduleVideoName = $moduleData['name'] . '_' . time() . '.' . $moduleVideo->getClientOriginalExtension();
                $moduleVideo->move(public_path('admin-assets/courses/modules/videos/'), $moduleVideoName);
                $module->video = 'admin-assets/courses/modules/videos/' . $moduleVideoName;
            }

            // Handle Module PDF Uploads
            if ($request->has("modules.$moduleIndex.pdf")) {
                $pdfFiles = $request->file("modules.$moduleIndex.pdf");
                $pdfPaths = [];

                foreach ($pdfFiles as $pdfFile) {
                    if ($pdfFile) {
                        $pdfName = $englishModuleSlug . '_' . uniqid() . '.' . $pdfFile->getClientOriginalExtension();
                        $pdfFile->move(public_path('admin-assets/courses/modules/pdfs/'), $pdfName);
                        $pdfPaths[] = 'admin-assets/courses/modules/pdfs/' . $pdfName;
                    }
                }

                // Store the PDF paths as a JSON string (or as a separate table if needed)
                $module->pdf = json_encode($pdfPaths); // Store as JSON
            }

            // Save Module
            $module->save();
        }
    }

    $course->save();

    return redirect()->back()->with('success', 'Course updated successfully!');
}



public function remove(Request $request)
    {
        // Validate that the 'id' is provided
        $request->validate([
            'id' => 'required|exists:modules,id'
        ]);

        // Find the module by ID and delete it
        $module = Module::findOrFail($request->id);

        try {
            $module->delete();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Module removed successfully!'
            ]);
        } catch (\Exception $e) {
            // Return an error response in case of failure
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove the module!'
            ], 500);
        }
    }


}
