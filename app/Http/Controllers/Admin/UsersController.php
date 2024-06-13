<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserTypes;
use App\Helpers\Media;
use App\Models\AdminProfileImage;
use App\Models\Blog;
use App\Models\CMS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Khsing\World\Models\Country;
use Khsing\World\Models\Division as State;
use Khsing\World\Models\City;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    private $users = null;
    private const STORAGE_PATH = 'public/uploads/media/user_media/';
    public function __construct()
    {
        $this->users = User::orderby('created_at', 'desc');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query()
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.country_id', 'users.state_id', 'users.city_id','users.created_at','users.status')
                ->where('role_id', 1)
                ->leftJoin('world_countries as countries', 'users.country_id', '=', 'countries.id')
                ->leftJoin('world_countries as states', 'users.state_id', '=', 'states.id')
                ->leftJoin('world_countries as cities', 'users.city_id', '=', 'cities.id');
    
            $dataTable = DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('users.id', function (User $user) {
                    // dd($user);
                    return $user->id;
                })
                ->addColumn('name', function (User $user) {
                    return $user->first_name . " " . $user->last_name;
                })
                ->addColumn('email', function (User $user) {
                    return $user->email;
                })
                ->addColumn('country', function (User $user) {
                    return $user->getUserDisplayFields()['country'];
                })
                ->addColumn('state', function (User $user) {
                    return $user->getUserDisplayFields()['state'];
                })
                ->addColumn('city', function (User $user) {
                    return $user->getUserDisplayFields()['city'];
                })
                ->addColumn('edit', function (User $user) {
                    return $user->id;
                })
                ->addColumn('view', function (User $user) {
                    return $user->id;
                })
                ->addColumn('delete', function (User $user) {
                    return $user->id;
                })
                ->addColumn('created_at', function (User $user) {
                    return $user->getCreatedAtForHumans();
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('email', function ($query, $keyword) {
                    $query->where('users.email', 'like', "%{$keyword}%");
                })
                ->filterColumn('country', function ($query, $keyword) {
                    $query->where('countries.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('state', function ($query, $keyword) {
                    $query->where('states.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('city', function ($query, $keyword) {
                    $query->where('cities.name', 'like', "%{$keyword}%");
                })
                ->orderColumn('created_at', 'users.created_at $1')
                ->orderColumn('name', 'users.first_name $1, users.last_name $1')
                ->orderColumn('email', 'users.email $1')
                ->orderColumn('country', 'countries.name $1')
                ->orderColumn('state', 'states.name $1')
                ->orderColumn('city', 'cities.name $1')
                ->make(true);

                return $dataTable;

        }
    
        return view('admin.users.index');
    }


    public function adminIndex(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query()
                ->where('role_id', 3)
                ->leftJoin('world_countries as countries', 'users.country_id', '=', 'countries.id')
                ->leftJoin('world_countries as states', 'users.state_id', '=', 'states.id')
                ->leftJoin('world_countries as cities', 'users.city_id', '=', 'cities.id');
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('name', function (User $user) {
                    return $user->first_name . " " . $user->last_name;
                })
                ->addColumn('email', function (User $user) {
                    return $user->email;
                })
                ->addColumn('country', function (User $user) {
                    return $user->getUserDisplayFields()['country'];
                })
                ->addColumn('state', function (User $user) {
                    return $user->getUserDisplayFields()['state'];
                })
                ->addColumn('city', function (User $user) {
                    return $user->getUserDisplayFields()['city'];
                })
                ->addColumn('edit', function (User $user) {
                    return $user->id;
                })
                ->addColumn('view', function (User $user) {
                    return $user->id;
                })
                ->addColumn('delete', function (User $user) {
                    return $user->id;
                })
                ->addColumn('created_at', function (User $user) {
                    return $user->getCreatedAtForHumans();
                })
                // Add searching functionality for specific columns
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(users.first_name, ' ', users.last_name) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('email', function ($query, $keyword) {
                    $query->where('users.email', 'like', "%{$keyword}%");
                })
                ->filterColumn('country', function ($query, $keyword) {
                    $query->where('countries.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('state', function ($query, $keyword) {
                    $query->where('states.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('city', function ($query, $keyword) {
                    $query->where('cities.name', 'like', "%{$keyword}%");
                })
                ->orderColumn('created_at', 'users.created_at $1')
                ->orderColumn('name', 'users.first_name $1, users.last_name $1')
                ->orderColumn('email', 'users.email $1')
                ->orderColumn('country', 'countries.name $1')
                ->orderColumn('state', 'states.name $1')
                ->orderColumn('city', 'cities.name $1')
                ->make(true);
        }
        return view('admin.users.admin-index');
    }
    public function create($type = UserTypes::LIST)
    {
        $country = Country::get();
        return view('admin.users.add', [
            'country' => $country,
            'type' => User::where('role_id', $type)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validationRules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'password' => ['required', 'string'],
            'country_id' => ['numeric'],
            'state_id' => ['numeric'],
            'city_id' => ['numeric'],
            'zip_code' => ['required'],
            'contact_number' => ['required'],
            'about_me' => ['string'],
            'gender' => ['string', 'in:male,female,other'],
            'date_of_birth' => ['date']
        ];
        // Create the validator instance
        $validator = Validator::make($request->all(), $validationRules);

        $image_name = null;
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('/images/users'), $image_name);
        }

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->with(['flash_error' => "Whoops! Something went wrong."]);
        }
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $image_name,
            'role_id' => 1,
            'status' => 1,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'zip_code' => $request->zip_code,
            'contact_number' => $request->contact_number,
            'about_me' => $request->about_me,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth
        ]);
        return redirect()->back()->with(['flash_success' => "Congratulations! User has been created."]);
    }

    public function view(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($user == null) {
            return Redirect::back()->with(['flash_error' => "User not found"]);
        }

        if ($request->isMethod('post')) {
            $validation = [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'country_id' => ['numeric'],
                'state_id' => ['numeric'],
                'city_id' => ['numeric'],
                'zip_code' => ['required'],
                'contact_number' => ['required'],
                'date_of_birth' => ['date'],
                'gender' => ['string', 'in:male,female,other'],
                'about_me' => ['string']
            ];

            $request->validate($validation);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->status = $request->status;
            $user->state_id = $request->state_id;
            $user->city_id = $request->city_id;
            $user->zip_code = $request->zip_code;
            $user->contact_number = $request->contact_number;
            $user->profile_picture = $request->profile_picture;
            $user->date_of_birth = $request->date_of_birth;
            $user->gender = $request->gender;
            $user->about_me = $request->about_me;
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $image_name = $user->id . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/users'), $image_name);
                $user->profile_picture = $image_name;
            }
            if ($user->save()) {
                return Redirect::back()->with(['flash_success' => "Congratulations!, User details are updated."]);
            }

            return Redirect::back()->with(['flash_error' => "Oops!, Something went wrong."]);
        }

        return view('admin.users.view', [
            "user" => $user,
            "users_url" => route('users.index', $user->role_id)
        ]);
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with(['flash_success' => "Congratulations! User account has been deleted."]);
    }

    public function uploadImage(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'profile_image' => 'image',
                'cover_image' => 'image',
            ]);
    
            $storagePath = 'public/uploads/media/user_media/';
    
            // Fetch existing image data
            $existingImages = AdminProfileImage::first();
    
            if ($existingImages) {
                if ($request->hasFile('profile_image')) {
                    if ($existingImages->profile_image) {
                        // Delete previous profile image
                        Storage::delete($storagePath . $existingImages->profile_image);
                    }
    
                    // Handle profile image upload
                    $profileImage = $request->file('profile_image');
                    $profileImageName = Media::convertFullUrl(Media::uploadMedia($profileImage));
                    $existingImages->profile_image = $profileImageName;
    
                    // Update the user's profile picture
                    $user = User::find(auth()->user()->id);
                    $user->profile_picture = $profileImageName;
                    $user->save();
                }
    
                // Handle cover image upload
                if ($request->hasFile('cover_image')) {
                    if ($existingImages->cover_image) {
                        // Delete previous cover image
                        Storage::delete($storagePath . $existingImages->cover_image);
                    }
    
                    // Handle cover image upload
                    $coverImage = $request->file('cover_image');
                    $coverImageName = Media::convertFullUrl(Media::uploadMedia($coverImage));
                    $existingImages->cover_image = $coverImageName;
                }
    
                $existingImages->save(); // Save changes to the database
            } else {
                // Handle profile image upload
                $profileImageName = null;
                if ($request->hasFile('profile_image')) {
                    $profileImage = $request->file('profile_image');
                    $profileImageName = Media::convertFullUrl(Media::uploadMedia($profileImage));
                }
    
                // Handle cover image upload
                $coverImageName = null;
                if ($request->hasFile('cover_image')) {
                    $coverImage = $request->file('cover_image');
                    $coverImageName = Media::convertFullUrl(Media::uploadMedia($coverImage));
                }
    
                // Save the image paths to the database
                AdminProfileImage::create([
                    'user_id' => auth()->user()->id,
                    'profile_image' => $profileImageName,
                    'cover_image' => $coverImageName,
                ]);
    
                // Update the user's profile picture
                $user = User::find(auth()->user()->id);
                $user->profile_picture = $profileImageName;
                $user->save();
            }
    
            // Redirect back or to any route you prefer
            return redirect()->back()->with('success', 'Images uploaded successfully.');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function deleteImage(Request $request)
    {
        $image = AdminProfileImage::first();
        if (!$image) {
            return redirect()->back()->with('error', 'Image not found.');
        }

        if ($request->has('profile_image')) {
            if ($request->input('profile_image')) {
                Storage::delete(self::STORAGE_PATH . $request->input('profile_image'));
                $image->profile_image = null;
                $image->save();
            }
        } elseif ($request->has('cover_image')) {
            if ($request->input('cover_image')) {
                Storage::delete(self::STORAGE_PATH . $request->input('cover_image'));
                $image->cover_image = null;
                $image->save();
            }
        }

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function about(Request $request)
    {
        if ($request->isMethod('post')) {
            $auth_user = auth()->user();
            $user = User::where('id', $auth_user->id)
                ->where('role_id', UserTypes::Admin)
                ->first();

            // Check if the authenticated user is an admin
            if (auth()->user()->role_id === UserTypes::Admin) {
                $validation = [
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'date_of_birth' => ['nullable', 'date'],
                    'gender' => ['nullable', 'string', 'in:male,female,other'],
                    'about_me' => ['nullable', 'string'],
                ];

                $request->validate($validation);
                $userData = $request->only(['first_name', 'last_name', 'date_of_birth', 'gender', 'about_me']);
                $user->update($userData);
                return redirect()->route('user.updateAbout')->with('flash_success', 'Profile updated successfully!');
            } else {
                return redirect()->back()->with('flash_error', 'Unauthorized access!');
            }
        }

        $user = auth()->user();
        $filledFields = 0;
        $requiredFields = ['first_name', 'last_name', 'date_of_birth', 'gender', 'about_me'];
        foreach ($requiredFields as $field) {
            if ($user->$field) {
                $filledFields++;
            }
        }
        $percentage = $filledFields * 20;
        $missingFields = count($requiredFields) - $filledFields;
        return view('admin.about.about', compact('user', 'percentage', 'missingFields'));
    }

    public function account(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);
        $user->first_name = $validatedData['first_name'];
        $user->email = $validatedData['email'];
        if ($request->has('password') && $request->input('password') !== null) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return redirect()->back()->with('flash_success', 'Profile updated successfully!');
    }

    public function blog(Request $request)
    {
        $user = Auth::user();
        if ($request->isMethod('post')) {
            $validation = $request->validate([
                'title' => 'required|unique:blogs,title',
                'content' => 'required',
            ]);

            if ($validation) {
                Blog::create([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'user_id' => $user->id,
                ]);
                return Redirect::route('admin.blog.view')->with('flash_success', 'Blog created successfully!');
            } else {
                return Redirect::back()->with('flash_error', 'Something went wrong');
            }
        }
        return view('admin.blog.blog');
    }

    public function viewBlog()
    {
        $blogs = Blog::get();
        return view('admin.blog.view', compact('blogs'));
    }

    public function blogDetail($id)
    {
        $blog = Blog::where('id', $id)->with('user')->first();
        return view('admin.blog.single_blog', compact('blog'));
    }


    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $blogs = [];

        if ($searchTerm) {
            $blogs = Blog::where('title', 'LIKE', '%' . $searchTerm . '%')->get();
        }
        return view('admin.blog.search_blog', compact('blogs'));
    }

    public function createAction($page_name, $request) {
        
        $cms = CMS::where('page_name', $page_name)->first();

        if ($cms == null) {
            $cms = new CMS();
            $cms->page_name = $page_name;
        }

        $cms->banner_heading = $request->has('banner_heading') ? $request->banner_heading : null;
        $cms->banner_description = $request->has('banner_description') ? $request->banner_description : null;
        $cms->about_heading = $request->has('about_heading') ? $request->about_heading : null;
        $cms->about_description = $request->has('about_description') ? $request->about_description : null;
        $cms->gallery_heading = $request->has('gallery_heading') ? $request->gallery_heading : null;
        $cms->gallery_description = $request->has('gallery_description') ? $request->gallery_description : null;

        if ($request->hasFile('banner_picture')) {
            // Delete the old image
            File::delete(public_path('images/cms/' . $cms->banner_picture));
        
            $image = $request->file('banner_picture');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('/images/cms'), $image_name);
            $cms->banner_picture = $image_name;
        }

        if ($request->hasFile('about_picture')) {
            // Delete the old image
            File::delete(public_path('images/cms/' . $cms->about_picture));
        
            $image = $request->file('about_picture');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('/images/cms'), $image_name);
            $cms->about_picture = $image_name;
        }
        if ($request->hasFile('gallery_picture')) {
            // Delete the old image
            File::delete(public_path('images/cms/' . $cms->gallery_picture));
        
            $image = $request->file('gallery_picture');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('/images/cms'), $image_name);
            $cms->gallery_picture = $image_name;
        }
        
    

        if ($cms->save()) {
            return Redirect::back()->with(['flash_success' => "Congratulations!, CMS page has been updated."]);
        }

        return Redirect::back()->with(['flash_error' => "Oops!, Something went wrong."]);
    }

    public function cms(Request $request)
    {
        $page_name = 'homepage';
        $cms = CMS::where('page_name', $page_name)->first();

        if ($request->isMethod('post')) {
            

            return $this->createAction($page_name, $request);
        }

        return view('admin.users.cms', compact('cms'));
    }
}
