<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SaveBankRequest;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BankController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $banks = Bank::orderBy('name')->get();
        return BankResource::collection($banks);
    }
}
