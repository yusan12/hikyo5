<?php
namespace App\Services;

use Exception;
use App\Repositories\MessageRepository;
use App\Repositories\ThreadRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThreadService
{
    /**
     * @var MessageRepository
     */
    protected $message_repository;

    /**
     * @var ThreadRepository
     */
    protected $thread_repository;

    /**
     * ThreadService constructor.
     *
     * @param MessageRepository $message_repository
     * @param ThreadRepository $thread_repository
     */
    public function __construct(
        MessageRepository $message_repository,
        ThreadRepository $thread_repository
    ) {
        $this->message_repository = $message_repository;
        $this->thread_repository = $thread_repository;
    }

    /**
     * Create new thread and first new message.
     *
     * @param array $data
     * @return Tread $thread
     */
    public function createNewThread(array $data, string $user_id)
    {
        DB::beginTransaction();
        try {
            $thread_data = $this->getThreadData($data['name'], $user_id, $data['content'], $data['place'], $data['introduction'], $data['time_from_tokyo'], $data['how_much_from_tokyo'], $data['caution'],);
            $thread = $this->thread_repository->create($thread_data);

            $message_data = $this->getMessageData($data['content'], $user_id, $thread->id);
            $this->message_repository->create($message_data);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());
            throw new Exception($error->getMessage());
        }
        DB::commit();
        
        return $thread;
    }
    /**
     * get thread data
     *
     * @param string $thread_name
     * @param string $user_id
     * @return array
     */
    public function getThreadData(string $thread_name, string $user_id, string $thread_place, string $thread_introduction, string $thread_time_from_tokyo, string $thread_how_much_from_tokyo, string $thread_caution)
    {
        return [
            'name' => $thread_name,
            'user_id' => $user_id,
            'place' => $thread_place,
            'introduction' => $thread_introduction,
            'time_from_tokyo' => $thread_time_from_tokyo,
            'how_much_from_tokyo' => $thread_how_much_from_tokyo,
            'caution' => $thread_caution
        ];
    }
    /**
     * get message data
     *
     * @param string $message
     * @param string $user_id
     * @param string $thread_id
     * @return array
     */
    public function getMessageData(string $message, string $user_id, string $thread_id)
    {
        return [
            'body' => $message,
            'user_id' => $user_id,
            'thread_id' => $thread_id
        ];
    }
}
