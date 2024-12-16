<div>
    <div class="row col-12">
        <div class="col-3">
            <h1>Queues</h1>
            <a class="btn btn-outline-primary mt-2 mb-2" href="/">Back</a>
        </div>
        <div class="col-9">
            <section class="content pb-3 mt-3">
                <div class="container-fluid h-100">
                    <div class="row">

                        <!-- Orders Section -->
                        <div class="col-4">
                            <div class="card card-row card-secondary">
                                <div class="card-header bg-secondary">
                                    <h3 class="card-title">Orders</h3>
                                </div>
                                <div class="card-body" style="height: 600px; overflow-y: auto;">
                                    <div class="accordion" id="accordionOrders">
                                        @foreach ($orders1 as $order)
                                        @if ($order->date == now()->format('Y-m-d'))
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{$order->id}}">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{$order->id}}"
                                                    aria-expanded="true"
                                                    aria-controls="collapse{{$order->id}}">
                                                    Queue: {{$order->queue}}
                                                </button>
                                            </h2>
                                            <div id="collapse{{$order->id}}" class="accordion-collapse collapse show"
                                                aria-labelledby="heading{{$order->id}}"
                                                data-bs-parent="#accordionOrders">
                                                <div class="accordion-body">
                                                    @foreach ($order->foods as $food)
                                                    <div class="form-check">
                                                        <li>
                                                            {{$food->name}} x
                                                            @foreach ($food->orderItems as $item)
                                                            @if ($item->order_id == $order->id)
                                                            {{$item->count}}
                                                            @endif
                                                            @endforeach
                                                        </li>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- In Progress Section -->
                        <div class="col-4">
                            <div class="card card-row card-primary">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title">In Progress</h3>
                                </div>
                                <div class="card-body" style="height: 600px; overflow-y: auto;">
                                    <div class="accordion" id="accordionInProgress">
                                        @foreach ($orders2 as $order)
                                        @if ($order->date == now()->format('Y-m-d'))
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{$order->id}}">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{$order->id}}"
                                                    aria-expanded="true"
                                                    aria-controls="collapse{{$order->id}}">
                                                    Queue: {{$order->queue}}
                                                </button>
                                            </h2>
                                            <div id="collapse{{$order->id}}" class="accordion-collapse collapse show"
                                                aria-labelledby="heading{{$order->id}}"
                                                data-bs-parent="#accordionInProgress">
                                                <div class="accordion-body">
                                                    @foreach ($order->foods as $food)
                                                    <div class="form-check">
                                                        <label class="form-check-label" for="flexCheckDefault"
                                                            style="
                                                                                @foreach ($food->orderItems as $item)
                                                                                    @if ($order->id == $item->order_id && $item->status == 3)
                                                                                        text-decoration-line: line-through;
                                                                                        @break
                                                                                    @endif
                                                                                @endforeach">
                                                            {{$food->name}} x
                                                            @foreach ($food->orderItems as $item)
                                                            @if ($item->order_id == $order->id)
                                                            {{$item->count}}
                                                            @endif
                                                            @endforeach
                                                        </label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Done Section -->
                        <div class="col-4">
                            <div class="card card-row card-default">
                                <div class="card-header bg-info">
                                    <h3 class="card-title">Done</h3>
                                </div>
                                <div class="card-body" style="height: 600px; overflow-y: auto;">
                                    <div class="accordion" id="accordionDone">
                                        @foreach ($orders3 as $order)
                                        @if ($order->date == now()->format('Y-m-d'))
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{$order->id}}">
                                                <button class="accordion-button" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{$order->id}}"
                                                    aria-expanded="true"
                                                    aria-controls="collapse{{$order->id}}">
                                                    Queue: {{$order->queue}}
                                                </button>
                                            </h2>
                                            <div id="collapse{{$order->id}}" class="accordion-collapse collapse show"
                                                aria-labelledby="heading{{$order->id}}"
                                                data-bs-parent="#accordionDone">
                                                <div class="accordion-body">
                                                    @foreach ($order->foods as $food)
                                                    <div class="form-check">
                                                        <li>
                                                            {{$food->name}} x
                                                            @foreach ($food->orderItems as $item)
                                                            @if ($item->order_id == $order->id)
                                                            {{$item->count}}
                                                            @endif
                                                            @endforeach
                                                        </li>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </section>
        </div>
    </div>



</div>