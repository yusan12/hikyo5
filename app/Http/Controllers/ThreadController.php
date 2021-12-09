<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ThreadRequest;
use App\Services\ThreadService;
use Illuminate\Support\Facades\Auth;
use Exception;
class ThreadController extends Controller
{
    /**
     * The ThreadService implementation.
     *
     * @var ThreadService
     */
    protected $thread_service;
    /**
     * Create a new controller instance.
     *
     * @param  ThreadService  $thread_service
     * @return void
     */
    public function __construct(
        ThreadService $thread_service
    ) {
        $this->middleware('auth')->except('index');
        $this->thread_service = $thread_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = $this->thread_service->getThreads(3);
        return view('threads.index', compact('threads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ThreadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        try {
            $data = $request->only(
                ['name', 'content', 'place', 'introduction', 'time_from_tokyo', 'how_much_from_tokyo', 'caution']
            );
            $this->thread_service->createNewThread($data, Auth::id());
        } catch (Exception $error) {
            return redirect()->route('threads.index')->with('error', 'スレッドの新規作成に失敗しました。');
        }
        // redirect to index method
        return redirect()->route('threads.index')->with('success', 'スレッドの新規作成が完了しました。');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
