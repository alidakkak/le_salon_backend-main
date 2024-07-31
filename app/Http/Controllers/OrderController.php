<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\MoveOrderToCasherRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\HttpResponse\CustomResponse;
use App\Models\Meal;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderitemOptional;
use App\Models\Table;
use App\SecurityChecker\Checker;
use App\Types\NotificationType;
use App\Types\OrderStates;

class OrderController extends Controller
{
    use Checker;
    use CustomResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }

        $orders = Order::all();

        return OrderResource::collection($orders);
    }

    public function kitchenOrders()
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }
        $orders = Order::where('order_state', OrderStates::KITCHEN_ORDER)->get();

        return OrderResource::collection($orders);
    }

    public function runnerOrders()
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }
        $orders = Order::where('order_state', OrderStates::RUNNER_ORDER)->get();

        return OrderResource::collection($orders);
    }

    public function casherOrders()
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }
        $orders = Order::where('order_state', OrderStates::CASHER_ORDER)->get();

        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'table_id' => $request->table_id,
        ]);
        $table = Table::where('id', $request->table_id)->first();

        $totalOrderPrice = 0;

        foreach ($request->order_items as $order_item) {
            $meal = Meal::where('id', $order_item['meal_id'])->first();

            $totalItem = $order_item['quantity'] * $meal->price;

            $orderItemData = array_merge($order_item, ['order_id' => $order->id, 'total' => $totalItem]);
            $orderItem = OrderItem::create($orderItemData);

            foreach ($order_item['optionalIngredient'] as $ingredient) {
                OrderitemOptional::create([
                    'order_item_id' => $orderItem->id,
                    'optional_id' => $ingredient,
                ]);
            }

            $totalOrderPrice += $totalItem;
        }

        $order->update([
            'total' => $totalOrderPrice,
        ]);

        $notification = Notification::create([
            'notification' => 'New order added for table number ' . $table->table_number,
            'type' => NotificationType::NEWORDER,
            'order_id' => $order->id,
        ]);
        return OrderResource::make($order);
    }


    public function show(Order $order)
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }

        return OrderResource::make($order);
    }

    public function destroy(Order $order)
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }

        $notification = Notification::create([
            'notification' => 'order number '.$order->id.' deleted from system ',
            'type' => NotificationType::DELETEORDER,
            'order_id' => $order->id,
        ]);
        $order->delete();

        return $this->success(null, 'order deleted successfully');
    }

    public function acceptOrder(Order $order)
    {
        $order->update([
            'order_state' => OrderStates::Accepted,
        ]);

//        $table = Table::where('id', $order->table_id)->first();
//        $notification = Notification::create([
//            'notification' => 'order number '.$order->id.' belongs to table number '.$table->id.'came to runner',
//            'type' => NotificationType::TORUNNER,
//            'order_id' => $order->id,
//            'order' => $order,
//        ]);

//        event(new NotificationEvent($notification));

        return $this->success($order, 'order accepted successfully');
    }

    public function rejectOrder(Order $order)
    {
        $order->update([
            'order_state' => OrderStates::rejected,
        ]);

        return $this->success($order, 'order rejected successfully');
    }

    public function moveToCasher(MoveOrderToCasherRequest $request, Order $order)
    {
        if ($this->isExtraFoundInBody(['receipt_id'])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }
        $request->validated($request->all());
        $order->update([
            'order_state' => OrderStates::CASHER_ORDER,
            'receipt_id' => $request->receipt_id,
        ]);
        $table = Table::where('id', $order->table_id)->first();
        $notification = Notification::create([
            'notification' => 'order number '.$order->id.' belongs to table number '.$table->id.'came to casher',
            'type' => NotificationType::TOCASHER,
            'order_id' => $order->id,
        ]);

        event(new NotificationEvent($notification));

        return $this->success($order, 'order updated successfully');
    }
}
