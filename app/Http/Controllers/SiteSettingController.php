<?php

namespace App\Http\Controllers;

use App\Models\HomePage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public static function siteSetting(){
        return view('admin.sitesettings.headersettings',[
            'siteSettings' => SiteSetting::find(1),
        ]);
    }

    public function siteSettingUpdate(Request $request)
    {
        $siteSettings = SiteSetting::find($request->id);

        // Update required fields
        $siteSettings->title = $request->title;
        $siteSettings->free_course = $request->free_course;

        // Handle logo upload and path saving
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($siteSettings->logo && file_exists(public_path($siteSettings->logo))) {
                unlink(public_path($siteSettings->logo));
            }
            // Store new logo and save the path
            $logoPath = $request->file('logo')->move('admin-assets/img/', 'logo'. rand() . '.' . $request->file('logo')->extension());
            $siteSettings->logo = $logoPath;
        }

        // Handle favicon upload and path saving
        if ($request->hasFile('favicon')) {
            // Delete old favicon if it exists
            if ($siteSettings->favicon && file_exists(public_path($siteSettings->favicon))) {
                unlink(public_path($siteSettings->favicon));
            }
            // Store new favicon and save the path
            $faviconPath = $request->file('favicon')->move('admin-assets/img/', 'favicon'.rand() . '.' . $request->file('favicon')->extension());
            $siteSettings->favicon = $faviconPath;
        }

        // Save the updated settings to the database
        $siteSettings->save();

        // Return success message
        return back()->with('success', 'Site settings have been updated successfully!');
    }

    public static function siteSettingUpdatetwo(Request $request){
        $siteSettings = SiteSetting::find($request->id);
        // Update other nullable fields
        $siteSettings->phone = $request->phone;
        $siteSettings->address = $request->address;
        $siteSettings->email = $request->email;
        $siteSettings->facebook = $request->facebook;
        $siteSettings->instagram = $request->instagram;
        $siteSettings->youtube = $request->youtube;
        $siteSettings->twitter = $request->twitter;

         // Save the updated settings to the database
         $siteSettings->save();

         // Return success message
         return back()->with('success', 'Site settings have been updated successfully!');
    }

    public static function homeSetting(){
        return view('admin.sitesettings.homeSetting',[
            'homeSetting' => HomePage::find(1),
        ]);
    }

    public static function homeSettingUpdate(Request $request) {
        $home = HomePage::find(1);
        $home->pretitle = $request->pretitle;
        $home->title = $request->title;
        $home->subtitle = $request->subtitle;

        if ($request->hasFile('image')) {
            if ($home->image && file_exists(public_path($home->image))) {
                unlink(public_path($home->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'admin-assets/images/' . $imageName;

            $image->move(public_path('admin-assets/images'), $imageName);

            $home->image = $imagePath;
        }


        if ($request->hasFile('video')) {

            if ($home->video && file_exists(public_path($home->video))) {
                unlink(public_path($home->video));
            }

            $video = $request->file('video');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $videoPath = 'admin-assets/videos/' . $videoName;

            $video->move(public_path('admin-assets/videos'), $videoName);

            $home->video = $videoPath;
        }

        $home->point_one = $request->point_one;
        $home->point_two = $request->point_two;
        $home->point_three = $request->point_three;
        $home->save();
        return back()->with('success', 'Home Page Settings Updated Successfully');
    }

    public static function homeSettingUpdatetwo(Request $request) {
        $home = HomePage::find(1);
        $home->service_one = $request->service_one;
        $home->service_two = $request->service_two;
        $home->service_three = $request->service_three;
        $home->service_four = $request->service_four;
        $home->service_five = $request->service_five;
        $home->save();
        return back()->with('success', 'Home Page Settings Updated Successfully');
    }

    public static function homeSettingUpdatethree(Request $request) {
        $home = HomePage::find(1);
        $home->aboutpretitle = $request->aboutpretitle;
        $home->abouttitle = $request->abouttitle;
        $home->aboutsubtitle = $request->aboutsubtitle;
        if ($request->hasFile('aboutimageone')) {
            if ($home->aboutimageone && file_exists(public_path($home->aboutimageone))) {
                unlink(public_path($home->aboutimageone));
            }

            $image = $request->file('aboutimageone');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'admin-assets/images/' . $imageName;

            $image->move(public_path('admin-assets/images'), $imageName);

            $home->aboutimageone = $imagePath;
        }
        if ($request->hasFile('aboutimagetwo')) {
            if ($home->aboutimagetwo && file_exists(public_path($home->aboutimagetwo))) {
                unlink(public_path($home->aboutimagetwo));
            }

            $image = $request->file('aboutimagetwo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'admin-assets/images/' . $imageName;

            $image->move(public_path('admin-assets/images'), $imageName);

            $home->aboutimagetwo = $imagePath;
        }
        $home->aboutpoint_one = $request->aboutpoint_one;
        $home->aboutpoint_two = $request->aboutpoint_two;
        $home->aboutpoint_three = $request->aboutpoint_three;
        $home->save();
        return back()->with('success', 'Home Page Settings Updated Successfully');
    }

    public static function homeSettingUpdatefour(Request $request) {
        $home = HomePage::find(1);
        $home->abouttwopretitle = $request->abouttwopretitle;
        $home->abouttwotitle = $request->abouttwotitle;
        $home->abouttwosubtitle = $request->abouttwosubtitle;
        if ($request->hasFile('abouttwoimageone')) {
            if ($home->abouttwoimageone && file_exists(public_path($home->abouttwoimageone))) {
                unlink(public_path($home->abouttwoimageone));
            }

            $image = $request->file('abouttwoimageone');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'admin-assets/images/' . $imageName;

            $image->move(public_path('admin-assets/images'), $imageName);

            $home->abouttwoimageone = $imagePath;
        }
        $home->abouttwopoint_one = $request->abouttwopoint_one;
        $home->abouttwopoint_two = $request->abouttwopoint_two;
        $home->abouttwopoint_three = $request->abouttwopoint_three;
        $home->save();
        return back()->with('success', 'Home Page Settings Updated Successfully');
    }

}
