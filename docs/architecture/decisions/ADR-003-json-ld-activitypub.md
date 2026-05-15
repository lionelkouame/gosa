# ADR-003 — JSON-LD and ActivityPub as inter-application protocol

**Date:** 2026-05-15
**Status:** Accepted
**Deciders:** Lionel KOUAME

---

## Context

GOSA is a registry of open source applications grouped into galaxies. As the project grows, multiple GOSA instances could coexist — hosted by different organizations or communities. Without a federation protocol, each instance is an isolated silo: applications and galaxies cannot be discovered or shared across instances.

We need to decide how GOSA instances communicate with each other and how application/galaxy data is represented over HTTP.

---

## Decision

We adopt **JSON-LD** (JSON for Linked Data) as the data format for all HTTP API responses, and we design the system to be **ActivityPub-compatible** from the ground up.

This means:

1. **All API responses are JSON-LD** — every resource carries `@context`, `@type`, and `@id`
2. **Domain events map to ActivityStreams 2.0 activities** — the vocabulary is used as-is where it fits
3. **ActivityPub federation is deferred** — Inbox/Outbox, HTTP Signatures, WebFinger, and Actor objects are implemented in a dedicated `Federation` bounded context in a later milestone
4. **The Domain layer is unaware of JSON-LD** — serialization is handled in the UI/Infrastructure layer only

---

## Mapping — Domain events → ActivityStreams

| Domain event | ActivityStreams activity | Object type |
|---|---|---|
| `GalaxyCreated` | `Create` | `Collection` |
| `GalaxyPublished` | `Announce` | `Collection` |
| `GalaxyArchived` | `Delete` | `Collection` |
| `ApplicationRegistered` | `Create` | `Application` (custom type) |
| `ApplicationAddedToGalaxy` | `Add` | `Application` in `Collection` |
| `ApplicationRemovedFromGalaxy` | `Remove` | `Application` from `Collection` |
| `ApplicationPublished` | `Announce` | `Application` |

---

## JSON-LD response example

`GET /galaxies/abc-123`:

```json
{
  "@context": [
    "https://www.w3.org/ns/activitystreams",
    {
      "gosa": "https://gosa.dev/ns#",
      "status": "gosa:status",
      "version": "gosa:version",
      "repository": "gosa:repository"
    }
  ],
  "@type": "Collection",
  "@id": "https://gosa.example.com/galaxies/abc-123",
  "name": "Best ecommerce apps",
  "status": "Published",
  "totalItems": 3,
  "items": [
    {
      "@type": "gosa:Application",
      "@id": "https://gosa.example.com/applications/xyz-456",
      "name": "OpenCart",
      "version": "4.0.2",
      "repository": "https://github.com/opencart/opencart"
    }
  ]
}
```

---

## Future — Federation bounded context

When federation is implemented, it will introduce:

```
src/
    Federation/
        Domain/
            Model/
                Actor.php        (a GOSA instance as an ActivityPub Actor)
                Inbox.php
                Outbox.php
            Port/
                ActivityPublisherInterface.php
                ActorResolverInterface.php
        Application/
            Command/
                PublishActivity.php
                ProcessIncomingActivity.php
        Infrastructure/
            Http/
                HttpActivityPublisher.php   (sends signed HTTP POST to remote Inbox)
                WebFingerResolver.php
            Symfony/
                Controller/
                    InboxController.php     (POST /{actor}/inbox)
                    OutboxController.php    (GET /{actor}/outbox)
```

The Domain and Application layers of `ApplicationRegistry` and `GalaxyRegistry` remain untouched — federation is a pure infrastructure concern.

---

## Consequences

**Positive**
- GOSA API is interoperable with any ActivityPub-aware tool from day one
- JSON-LD gives semantic meaning to resources — machines can understand what an `Application` or `Galaxy` is without reading documentation
- Federation can be activated later without changing the domain model
- Aligned with the open source / decentralized philosophy of the project

**Negative**
- JSON-LD serialization adds a layer of complexity in the UI/Infrastructure layer
- Controllers and response DTOs must always include `@context`, `@type`, `@id`
- A custom JSON-LD context (`https://gosa.dev/ns#`) needs to be published and maintained

**Neutral**
- ActivityPub full compliance (HTTP Signatures, WebFinger) is deferred — this ADR does not commit to a timeline for federation

---

## Alternatives considered

### Plain JSON REST
Standard approach, widely understood. Rejected because it produces isolated instances with no path to federation.

### GraphQL
Flexible querying but no standard federation story and no semantic interoperability. Rejected.

### gRPC / Protocol Buffers
Efficient for internal service communication but not designed for open web federation. Rejected.

---

## References

- [ActivityPub — W3C Recommendation](https://www.w3.org/TR/activitypub/)
- [ActivityStreams 2.0 — W3C Recommendation](https://www.w3.org/TR/activitystreams-core/)
- [JSON-LD 1.1 — W3C Recommendation](https://www.w3.org/TR/json-ld11/)
- [ADR-002 — PHP without framework](./ADR-002-php-pur-sans-framework.md)
- [US-004 — Galaxy](../stories/US-004-galaxy.md)
