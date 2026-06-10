# University Portal — Developer Docs

Guides for understanding and extending the University Portal.

| Doc | What it covers |
|-----|----------------|
| **[ARCHITECTURE.md](ARCHITECTURE.md)** | How the layers fit together (Controller → Service → DTO → Blade) and why. **Read this first.** |
| **[ADDING-A-CRUD-MODULE.md](ADDING-A-CRUD-MODULE.md)** | Step-by-step: add a brand-new CRUD module end to end, with a full worked example (Classrooms). Also covers adding a single non-CRUD page. |
| **[CHEATSHEET.md](CHEATSHEET.md)** | Quick reference: Artisan commands, the CRUD route map, Blade snippets, validation rules, DTO getters, CSS classes. |

## The 30-second version

Every feature is the same six pieces:

```
Migration  ->  DTO  ->  Service  ->  Controller  ->  Routes  ->  Views
 (table)     (data)   (db access)    (the glue)     (URLs)    (screens)
```

To add something new, copy an existing module and rename it. The full walkthrough is in **[ADDING-A-CRUD-MODULE.md](ADDING-A-CRUD-MODULE.md)**.
