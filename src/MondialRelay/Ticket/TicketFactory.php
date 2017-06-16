<?php

namespace MondialRelay\Ticket;


class TicketFactory
{

    public function create($stat, $urlPDFA4, $urlPDFA5, $url10x15)
    {
        return new Ticket($stat, $urlPDFA4, $urlPDFA5, $url10x15);
    }
}